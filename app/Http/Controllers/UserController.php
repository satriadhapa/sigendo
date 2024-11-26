<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProgramStudi;

class UserController extends Controller
{
    /**
     * Show user profile.
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('profil_user', compact('user'));
    }

    /**
     * Show edit profile form.
     */
    public function editProfile()
    {
        $user = Auth::user();
        $program_studi = ProgramStudi::all(); // Fetch all Program Studi records
        return view('edit_profiluser', compact('user', 'program_studi'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate the data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_induk_pegawai' => 'nullable|string|max:20',
            'jabatan_akademik' => 'nullable|string|max:100',
            'program_studi_id' => 'nullable|exists:program_studi,id',
            'image' => 'nullable|mimes:png,jpg,jpeg'
        ]);
        if($request->has('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time(). '.'. $extension;
            $path = 'user/';
            $file->move($path, $filename);
        }

        // Update user data
        $user->update([
            'name'=> $request->input('name'), 
            'email' => $request->input('email'),
            'image' => $path.$filename, 
            'nomor_induk_pegawai' => $request->input('nomor_induk_pegawai'), 
            'jabatan_akademik' => $request->input('jabatan_akademik'), 
            'program_studi_id' => $request->input('program_studi_id')
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }
}
