<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\JamKuliah;


class DashboardController extends Controller
{
    public function admin(){
        $programStudiCount = ProgramStudi::count();
        $dosenCount = User::count();
        $mataKuliahCount = MataKuliah::count();
        $ruanganCount = Ruangan::count();

        return view('dashboard_admin', compact('mataKuliahCount', 'dosenCount', 'ruanganCount', 'programStudiCount')); // , 'dosenCount', 'mataKuliahCount', 'ruanganCount'
    }
    public function user(){
        return view('dashboard_user');
    }

    public function showScheduleForm()
        {
            $user = Auth::user();

            // Fetch Mata Kuliah based on the user's Program Studi
            $mata_kuliahs = MataKuliah::where('program_studi_id', $user->program_studi_id)->get();

            // Fetch all Jam Kuliah and Ruangan data
            $jam_kuliahs = JamKuliah::all();
            $ruangans = Ruangan::all();

            return view('dashboard_user', compact('mata_kuliahs', 'jam_kuliahs', 'ruangans', 'user'));
        }
}
