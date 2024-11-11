<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Ruangan;


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
}
