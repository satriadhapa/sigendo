<?php

namespace App\Services;

use Carbon\Carbon;

class SchedulingGeneticAlgorithm
{
    protected $params;
    protected $population = [];
    protected $initialSchedule = [];
    protected $scheduleDuration;

    public function __construct($params)
    {
        set_time_limit(2000);
        $this->params = $params;
        $this->scheduleDuration = $this->calculateScheduleDates(
            $params['tanggal_mulai'],
            $params['durasi_jadwal']
        );
    }

    protected function calculateScheduleDates($startDate, $durationWeeks)
    {
        $dates = [];
        $start = Carbon::parse($startDate);
        $end = $start->copy()->addWeeks($durationWeeks);

        while ($start->lte($end)) {
            $dates[] = $start->format('Y-m-d');
            $start->addDay();
        }

        return $dates;
    }

    protected function initializePopulation($populationSize)
    {
        for ($i = 0; $i < $populationSize; $i++) {
            $this->population[] = $this->createRandomSchedule();
        }
    }

    protected function createRandomSchedule()
    {
        if (!empty($this->initialSchedule)) {
            return $this->generateScheduleFromFirstWeek();
        }

        $schedule = [];
        $usedTimeSlots = [];
        $usedRooms = [];
        $usedClasses = [];

        foreach (array_slice($this->scheduleDuration, 0, 7) as $tanggal) { // Hanya 1 minggu pertama
            $dailySchedule = [];
            while (count($dailySchedule) < 2) {
                $mataKuliah = $this->getRandomElement($this->params['mata_kuliah']);
                $kelas = $this->getRandomElement(explode(',', $this->params['jumlah_kelas']));
                $jam = $this->getRandomElement($this->params['jam_kuliah']);
                $ruangan = $this->getRandomElement($this->params['ruangan']);

                $timeSlotKey = "$tanggal-$jam";
                $roomKey = "$tanggal-$jam-$ruangan";
                $classKey = "$tanggal-$kelas";

                if (
                    !isset($usedTimeSlots[$timeSlotKey]) &&
                    !isset($usedRooms[$roomKey]) &&
                    !isset($usedClasses[$classKey])
                ) {
                    $usedTimeSlots[$timeSlotKey] = true;
                    $usedRooms[$roomKey] = true;
                    $usedClasses[$classKey] = true;

                    $dailySchedule[] = [
                        'tanggal' => $tanggal,
                        'jam' => $jam,
                        'mata_kuliah' => $mataKuliah,
                        'kelas' => $kelas,
                        'ruangan' => $ruangan,
                    ];
                }
            }

            $schedule = array_merge($schedule, $dailySchedule);
        }

        $this->initialSchedule = $schedule; // Simpan jadwal awal
        return $schedule;
    }

    protected function generateScheduleFromFirstWeek()
    {
        $schedule = [];
        $initialDates = array_column($this->initialSchedule, 'tanggal');
        $weekCount = ceil(count($this->scheduleDuration) / 7);

        for ($week = 0; $week < $weekCount; $week++) {
            foreach ($this->initialSchedule as $entry) {
                $originalDate = Carbon::parse($entry['tanggal']);
                $newDate = $originalDate->copy()->addWeeks($week);

                if (Carbon::parse($this->scheduleDuration[0])->diffInDays($newDate) >= count($this->scheduleDuration)) {
                    break;
                }

                $schedule[] = [
                    'tanggal' => $newDate->format('Y-m-d'),
                    'jam' => $entry['jam'],
                    'mata_kuliah' => $entry['mata_kuliah'],
                    'kelas' => $entry['kelas'],
                    'ruangan' => $entry['ruangan'],
                ];
            }
        }

        return $schedule;
    }

    protected function evaluateFitness($schedule)
    {
        $penalty = 0;
        $usedTimeSlots = [];
        $usedRooms = [];
        $usedClasses = [];

        foreach ($schedule as $entry) {
            $timeSlotKey = "{$entry['tanggal']}-{$entry['jam']}";
            $roomKey = "{$entry['tanggal']}-{$entry['jam']}-{$entry['ruangan']}";
            $classKey = "{$entry['tanggal']}-{$entry['kelas']}";

            if (isset($usedTimeSlots[$timeSlotKey])) {
                $penalty++;
            }
            if (isset($usedRooms[$roomKey])) {
                $penalty++;
            }
            if (isset($usedClasses[$classKey])) {
                $penalty++;
            }

            $usedTimeSlots[$timeSlotKey] = true;
            $usedRooms[$roomKey] = true;
            $usedClasses[$classKey] = true;
        }

        return 1 / (1 + $penalty);
    }

    protected function performCrossover($parent1, $parent2)
    {
        $point = rand(0, count($parent1) - 1);
        return array_merge(array_slice($parent1, 0, $point), array_slice($parent2, $point));
    }

    protected function performMutation($schedule, $mutationProbability)
    {
        foreach ($schedule as &$entry) {
            if (rand(0, 100) / 100 <= $mutationProbability) {
                $entry['tanggal'] = $this->getRandomElement($this->scheduleDuration);
                $entry['jam'] = $this->getRandomElement($this->params['jam_kuliah']);
                $entry['ruangan'] = $this->getRandomElement($this->params['ruangan']);
            }
        }

        return $schedule;
    }

    protected function getRandomElement($array)
    {
        return $array[array_rand($array)];
    }

    public function run()
    {
        set_time_limit(2000);
        $this->initializePopulation($this->params['jumlah_populasi']);

        for ($generation = 0; $generation < $this->params['jumlah_generasi']; $generation++) {
            $fitnessScores = array_map([$this, 'evaluateFitness'], $this->population);

            $nextGeneration = [];
            while (count($nextGeneration) < $this->params['jumlah_populasi']) {
                $parent1 = $this->selectParent($fitnessScores);
                $parent2 = $this->selectParent($fitnessScores);

                $child = $this->performCrossover($this->population[$parent1], $this->population[$parent2]);
                $child = $this->performMutation($child, $this->params['probabilitas_mutasi']);

                $nextGeneration[] = $child;
            }

            $this->population = $nextGeneration;
        }

        return $this->getBestSchedule();
    }

    protected function selectParent($fitnessScores)
    {
        $totalFitness = array_sum($fitnessScores);
        $random = rand(0, $totalFitness * 1000) / 1000;

        foreach ($fitnessScores as $index => $fitness) {
            $random -= $fitness;
            if ($random <= 0) {
                return $index;
            }
        }

        return array_key_last($fitnessScores);
    }

    protected function getBestSchedule()
    {
        $fitnessScores = array_map([$this, 'evaluateFitness'], $this->population);
        $bestIndex = array_keys($fitnessScores, max($fitnessScores))[0];
        $bestSchedule = $this->population[$bestIndex];

        usort($bestSchedule, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        return $bestSchedule;
    }
}
