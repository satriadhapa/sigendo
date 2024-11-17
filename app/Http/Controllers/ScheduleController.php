<?php

// File: app/Http/Controllers/ScheduleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\JamKuliah;
use App\Models\Ruangan;
use App\Services\SchedulingGeneticAlgorithm; // Correct import statement

class ScheduleController extends Controller
{
    public function index()
    {
        $mata_kuliahs = MataKuliah::all();
        $jam_kuliahs = JamKuliah::all();
        $ruangans = Ruangan::all();

        return view('dashboard_user', compact('mata_kuliahs', 'jam_kuliahs', 'ruangans'));
    }

    public function generate(Request $request)
    {
        $params = $request->validate([
            'probabilitas_cross_over' => 'required|numeric|min:0|max:1',
            'jumlah_populasi' => 'required|integer|min:1',
            'probabilitas_mutasi' => 'required|numeric|min:0|max:1',
            'jumlah_generasi' => 'required|integer|min:1',
            'jumlah_kelas' => 'required|string',
            'mata_kuliah' => 'required|array',
            'hari_mengajar' => 'required|array',
            'tanggal_mulai' => 'required|date',
            'durasi_jadwal' => 'required|integer|min:1',
            'jam_kuliah' => 'required|array',
        ]);

        // Initialize SchedulingGeneticAlgorithm with validated parameters
        $schedulingGA = new SchedulingGeneticAlgorithm($params);
        
        // Run the algorithm and get the generated schedule
        $schedule = $schedulingGA->run();
        
        // Return the schedule to the result view
        return view('result', compact('schedule'));
    }
}
