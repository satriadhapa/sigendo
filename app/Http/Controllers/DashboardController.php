<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin(){
        return view('dashboard_admin');
    }
    public function user(){
        return view('dashboard_user');
    }
}
