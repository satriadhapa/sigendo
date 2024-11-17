<?php

namespace App\Services;

use Carbon\Carbon;

class SchedulingGeneticAlgorithm
{
    protected $params;
    protected $population = [];
    protected $scheduleDuration;

    public function __construct($params)
    {
        set_time_limit(2000); // 300 detik (5 menit)
        $this->params = $params;
        $this->scheduleDuration = $this->calculateScheduleDates(
            $params['tanggal_mulai'],
            $params['durasi_jadwal'],
            $params['hari_mengajar']
        );
    }

    // Generate schedule dates based on selected days and duration
    protected function calculateScheduleDates($startDate, $durationMonths, $allowedDays)
    {
        $dates = [];
        $start = Carbon::parse($startDate);
        $end = $start->copy()->addMonths($durationMonths);

        while ($start->lte($end)) {
            if (in_array($start->locale('id')->dayName, $allowedDays)) {
                $dates[] = $start->format('Y-m-d');
            }
            $start->addDay();
        }

        return $dates;
    }

    // Initialize population
    protected function initializePopulation($populationSize)
    {
        $baseSchedule = $this->createRandomSchedule();

        for ($i = 0; $i < $populationSize; $i++) {
            $this->population[] = $this->performMutation($baseSchedule, $this->params['probabilitas_mutasi']);
        }
    }

    // Create random schedule
    protected function createRandomSchedule()
    {
        $schedule = [];

        foreach ($this->scheduleDuration as $tanggal) {
            foreach ($this->params['mata_kuliah'] as $mataKuliah) {
                foreach ($this->params['jam_kuliah'] as $jam) {
                    $kelas = $this->getRandomElement(explode(',', $this->params['jumlah_kelas']));

                    $schedule[] = [
                        'tanggal' => $tanggal,
                        'hari' => Carbon::parse($tanggal)->locale('id')->dayName,
                        'jam' => $jam,
                        'mata_kuliah' => $mataKuliah,
                        'kelas' => $kelas,
                    ];
                }
            }
        }

        return $schedule;
    }

    // Fitness function
    protected function evaluateFitness($schedule)
    {
        $penalty = 0;

        foreach ($schedule as $index => $entry) {
            foreach ($schedule as $compareIndex => $compareEntry) {
                if ($index !== $compareIndex && $entry['tanggal'] === $compareEntry['tanggal'] && $entry['jam'] === $compareEntry['jam']) {
                    $penalty++;
                }
            }
        }

        return 1 / (1 + $penalty);
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
