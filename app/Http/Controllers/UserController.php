<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\JamKuliah;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    
    public function showProfile()
    {
        $user = Auth::user();
        return view('profil_user', compact('user'));
    }
    public function editProfile()
    {
        $user = Auth::user();
        $program_studi = ProgramStudi::all(); // Fetch all Program Studi records
        return view('edit_profiluser', compact('user', 'program_studi'));

    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate the data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_induk_pegawai' => 'required|string|max:20',
            'jabatan_akademik' => 'required|string|max:100',
            'program_studi_id' => 'required|exists:program_studi,id',
        ]);

        // Update user data
        $user->update($request->only(['name', 'email', 'nomor_induk_pegawai', 'jabatan_akademik', 'program_studi_id']));

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

}