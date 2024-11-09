<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;

class DashboardController extends Controller
{
    public function admin(){
        $programStudiCount = ProgramStudi::count();
        // $dosenCount = Dosen::count();
        // $mataKuliahCount = MataKuliah::count();
        // $ruanganCount = Ruangan::count();

        return view('dashboard_admin', compact('programStudiCount')); // , 'dosenCount', 'mataKuliahCount', 'ruanganCount'
    }
    public function user(){
        return view('dashboard_user');
    }
}
