<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class SchedulingGeneticAlgorithm
{
    protected $populationSize;
    protected $crossoverProbability;
    protected $mutationProbability;
    protected $generations;
    protected $classCount;
    protected $subjects;
    protected $teachingDays;
    protected $teachingHours;
    protected $rooms;
    protected $batchYears;
    protected $startDate;
    protected $scheduleDuration;

    protected $population;

    public function __construct($data)
    {
        $this->populationSize = $data['jumlah_populasi'];
        $this->crossoverProbability = $data['probabilitas_cross_over'];
        $this->mutationProbability = $data['probabilitas_mutasi'];
        $this->generations = $data['jumlah_generasi'];
        $this->classCount = explode(',', $data['jumlah_kelas']);
        $this->subjects = $data['mata_kuliah'];
        $this->teachingDays = $data['hari_mengajar'];
        $this->teachingHours = $data['jam_kuliah'];
        $this->rooms = $data['ruangan'];
        $this->batchYears = $data['angkatan'];
        $this->startDate = Carbon::parse($data['tanggal_mulai']);
        $this->scheduleDuration = $data['durasi_jadwal'];
        
        $this->population = new Collection();
    }

    /**
     * Generate the schedule using genetic algorithm steps.
     */
    public function generateSchedule()
    {
        $this->initializePopulation();

        for ($generation = 0; $generation < $this->generations; $generation++) {
            $this->evaluateFitness();
            $this->selection();
            $this->crossover();
            $this->mutate();
        }

        return $this->getBestSchedule();
    }

    /**
     * Initialize the population randomly.
     */
    protected function initializePopulation()
    {
        for ($i = 0; $i < $this->populationSize; $i++) {
            $individual = $this->createRandomSchedule();
            $this->population->push($individual);
        }
    }

    /**
     * Create a random schedule (individual).
     */
    protected function createRandomSchedule()
    {
        $schedule = [];
        foreach ($this->classCount as $class) {
            foreach ($this->subjects as $subject) {
                $schedule[] = [
                    'class' => $class,
                    'subject' => $subject,
                    'day' => $this->teachingDays[array_rand($this->teachingDays)],
                    'hour' => $this->teachingHours[array_rand($this->teachingHours)],
                    'room' => $this->rooms[array_rand($this->rooms)],
                    'batch' => $this->batchYears[array_rand($this->batchYears)],
                ];
            }
        }
        return $schedule;
    }

    /**
     * Evaluate the fitness of each individual in the population.
     */
    protected function evaluateFitness()
    {
        foreach ($this->population as &$individual) {
            $individual['fitness'] = $this->calculateFitness($individual);
        }
    }

    /**
     * Calculate fitness based on scheduling constraints.
     */
    protected function calculateFitness($schedule)
    {
        $fitness = 0;
        // Check for constraints, such as no overlapping schedules or room availability.
        foreach ($schedule as $event) {
            // Adjust fitness score based on constraints
            $fitness += 1;  // This is a placeholder
        }
        return $fitness;
    }

    /**
     * Selection of individuals for reproduction.
     */
    protected function selection()
    {
        // Use a selection method like roulette wheel or tournament selection
        $this->population = $this->population->sortByDesc('fitness')->take($this->populationSize / 2);
    }

    /**
     * Perform crossover on selected individuals.
     */
    protected function crossover()
    {
        $offspring = new Collection();
        foreach ($this->population->chunk(2) as $parents) {
            if (rand(0, 100) / 100 <= $this->crossoverProbability) {
                $child1 = $this->crossoverIndividuals($parents[0], $parents[1]);
                $child2 = $this->crossoverIndividuals($parents[1], $parents[0]);
                $offspring->push($child1, $child2);
            }
        }
        $this->population = $this->population->merge($offspring);
    }

    /**
     * Perform mutation on individuals.
     */
    protected function mutate()
    {
        foreach ($this->population as &$individual) {
            if (rand(0, 100) / 100 <= $this->mutationProbability) {
                $this->mutateIndividual($individual);
            }
        }
    }

    /**
     * Perform crossover between two individuals.
     */
    protected function crossoverIndividuals($parent1, $parent2)
    {
        $crossoverPoint = rand(1, count($parent1) - 1);
        $child = array_merge(array_slice($parent1, 0, $crossoverPoint), array_slice($parent2, $crossoverPoint));
        return $child;
    }

    /**
     * Mutate an individual by randomly changing one of its properties.
     */
    protected function mutateIndividual(&$individual)
    {
        $index = array_rand($individual);
        $individual[$index]['day'] = $this->teachingDays[array_rand($this->teachingDays)];
    }

    /**
     * Get the best schedule from the population.
     */
    protected function getBestSchedule()
    {
        return $this->population->sortByDesc('fitness')->first();
    }
}
