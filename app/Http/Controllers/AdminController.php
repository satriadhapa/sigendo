<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        return view('profile_admin');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nomor_induk_pegawai' => 'nullable|string|max:50',
            'jabatan_akademik' => 'nullable|string|max:100',
        ]);

        $admin = Auth::user();
        $admin->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'nomor_induk_pegawai' => $request->input('nomor_induk_pegawai'),
            'jabatan_akademik' => $request->input('jabatan_akademik'),
        ]);

        return redirect()->route('admin.profile.update')->with('success', 'Profile updated successfully.');
    }
}
