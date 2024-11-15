<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchedulingGeneticAlgorithm;
use App\Models\MataKuliah;
use App\Models\JamKuliah;
use App\Models\Ruangan;

class ScheduleController extends Controller
{
    /**
     * Display the schedule generation form.
     */
    public function index()
    {
        // Fetch data needed for the form
        $mataKuliahs = MataKuliah::all();
        $jamKuliahs = JamKuliah::all();
        $ruangans = Ruangan::all();

        return view('dashboard_user.schedule_form', compact('mataKuliahs', 'jamKuliahs', 'ruangans'));
    }

    /**
     * Generate the schedule using a genetic algorithm.
     */
    public function generate(Request $request)
    {   
        
        // Validate form input
        $validatedData = $request->validate([
            'probabilitas_cross_over' => 'required|numeric|min:0|max:1',
            'jumlah_populasi' => 'required|integer|min:1',
            'probabilitas_mutasi' => 'required|numeric|min:0|max:1',
            'jumlah_generasi' => 'required|integer|min:1',
            'jumlah_kelas' => 'required|string',
            'mata_kuliah' => 'required|array|max:3',
            'hari_mengajar' => 'required|array',
            'tanggal_mulai' => 'required|date',
            'jam_kuliah' => 'required|array',
            'ruangan' => 'required|array',
            'angkatan' => 'required|string',
            'durasi_jadwal' => 'required|integer|min:1',
        ]);

        // Initialize and run the scheduling genetic algorithm
        $scheduleService = new SchedulingGeneticAlgorithm($validatedData);
        $generatedSchedule = $scheduleService->generateSchedule();
        // Pass the generated schedule to the result view
        return view('result', compact('generatedSchedule'));
    }
}
