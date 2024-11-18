<?php

namespace App\Services;

use Carbon\Carbon;

class SchedulingGeneticAlgorithm
{
    protected $params;
    protected $population = [];
    protected $scheduleDuration;
    protected $daysPerWeek = 2; // Batas jumlah hari mengajar per minggu

    public function __construct($params)
    {
        set_time_limit(2000); // 300 detik (5 menit)
        $this->params = $params;
        $this->scheduleDuration = $this->calculateScheduleDates(
            $params['tanggal_mulai'],
            $params['durasi_jadwal']
        );
    }

    // Generate schedule dates based on duration
    protected function calculateScheduleDates($startDate, $durationMonths)
    {
        $dates = [];
        $start = Carbon::parse($startDate);
        $end = $start->copy()->addMonths($durationMonths);

        while ($start->lte($end)) {
            $dates[] = $start->format('Y-m-d');
            $start->addDay();
        }

        return $dates;
    }

    // Initialize population
    protected function initializePopulation($populationSize)
    {
        for ($i = 0; $i < $populationSize; $i++) {
            $this->population[] = $this->createRandomSchedule();
        }
    }

    // Create random schedule with weekly teaching day limits
    protected function createRandomSchedule()
    {
        $schedule = [];
        $usedSlots = []; // Untuk melacak slot waktu yang telah digunakan
        $weeklyTeachingDays = []; // Melacak jumlah hari mengajar per minggu

        foreach ($this->scheduleDuration as $tanggal) {
            $week = Carbon::parse($tanggal)->weekOfYear;

            foreach ($this->params['mata_kuliah'] as $mataKuliah) {
                foreach ($this->params['jam_kuliah'] as $jam) {
                    $kelas = $this->getRandomElement(explode(',', $this->params['jumlah_kelas']));
                    $ruangan = $this->getRandomElement($this->params['ruangan']);

                    $slot = "$tanggal-$jam-$ruangan"; // Identifikasi slot waktu dan ruangan

                    // Pastikan jumlah hari mengajar per minggu <= 2
                    if (!isset($weeklyTeachingDays[$mataKuliah][$week])) {
                        $weeklyTeachingDays[$mataKuliah][$week] = 0;
                    }

                    if ($weeklyTeachingDays[$mataKuliah][$week] < $this->daysPerWeek &&
                        !isset($usedSlots[$slot])) {
                        // Tambahkan jadwal jika slot belum digunakan
                        $schedule[] = [
                            'tanggal' => $tanggal,
                            'jam' => $jam,
                            'mata_kuliah' => $mataKuliah,
                            'kelas' => $kelas,
                            'ruangan' => $ruangan,
                        ];

                        // Tandai slot dan update jumlah hari
                        $usedSlots[$slot] = true;
                        $weeklyTeachingDays[$mataKuliah][$week]++;
                    }
                }
            }
        }

        return $schedule;
    }

    // Fitness function
    protected function evaluateFitness($schedule)
    {
        $penalty = 0;
        $usedSlots = []; // Untuk memeriksa konflik waktu dan ruangan
        $weeklyTeachingDays = []; // Melacak jumlah hari mengajar per minggu

        foreach ($schedule as $entry) {
            $slot = "{$entry['tanggal']}-{$entry['jam']}-{$entry['ruangan']}";
            $teacherSlot = "{$entry['tanggal']}-{$entry['jam']}-{$entry['mata_kuliah']}";
            $week = Carbon::parse($entry['tanggal'])->weekOfYear;

            // Periksa konflik ruangan
            if (isset($usedSlots[$slot])) {
                $penalty++;
            }

            // Periksa konflik dosen (mengajar lebih dari satu mata kuliah di waktu yang sama)
            if (isset($usedSlots[$teacherSlot])) {
                $penalty++;
            }

            // Periksa batas hari mengajar per minggu
            if (!isset($weeklyTeachingDays[$entry['mata_kuliah']][$week])) {
                $weeklyTeachingDays[$entry['mata_kuliah']][$week] = 0;
            }
            $weeklyTeachingDays[$entry['mata_kuliah']][$week]++;

            if ($weeklyTeachingDays[$entry['mata_kuliah']][$week] > $this->daysPerWeek) {
                $penalty++;
            }

            $usedSlots[$slot] = true;
            $usedSlots[$teacherSlot] = true;
        }

        return 1 / (1 + $penalty); // Nilai fitness semakin tinggi jika penalty kecil
    }

    // Perform crossover
    protected function performCrossover($parent1, $parent2)
    {
        $point = rand(0, count($parent1) - 1);
        return array_merge(array_slice($parent1, 0, $point), array_slice($parent2, $point));
    }

    // Perform mutation
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

    // Get random element
    protected function getRandomElement($array)
    {
        return $array[array_rand($array)];
    }

    // Run the genetic algorithm
    public function run()
    {
        set_time_limit(2000);
        $this->initializePopulation($this->params['jumlah_populasi']);

        for ($generation = 0; $generation < $this->params['jumlah_generasi']; $generation++) {
            $fitnessScores = array_map([$this, 'evaluateFitness'], $this->population);

            // Select parents and perform crossover
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

        // Return best schedule
        return $this->getBestSchedule();
    }

    // Select parent based on fitness
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

    // Get the best schedule from the population
    protected function getBestSchedule()
    {
        $fitnessScores = array_map([$this, 'evaluateFitness'], $this->population);
        $bestIndex = array_keys($fitnessScores, max($fitnessScores))[0];
        $bestSchedule = $this->population[$bestIndex];

        // Urutkan jadwal berdasarkan tanggal
        usort($bestSchedule, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        return $bestSchedule;
    }
}
