<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramStudi;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        $admin = Auth::user();
        $programStudies = ProgramStudi::all();
        
        return view('profile_admin', compact('admin', 'programStudies'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_induk_pegawai' => 'nullable|string|max:50',
            'jabatan_akademik' => 'nullable|string|max:100',
            'program_studi_id' => 'nullable|exists:program_studi,id',
        ]);

        $admin = Auth::user();
        $admin->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'nomor_induk_pegawai' => $request->input('nomor_induk_pegawai'),
            'jabatan_akademik' => $request->input('jabatan_akademik'),
            'program_studi_id' => $request->input('program_studi_id'),
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    // Display the list of Program Studi
    public function programStudi()
    {
        // Paginate program studi, 5 items per page
        $programStudi = ProgramStudi::paginate(5);
        return view('prodi_admin', compact('programStudi'));
    }

    // Show the form for creating a new Program Studi
    public function createProgramStudi()
    {
        return view('create_program_studi');
    }

    // Store a newly created Program Studi in the database
    public function storeProgramStudi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:program_studi,kode',
        ]);

        ProgramStudi::create([
            'name' => $request->input('name'),
            'kode' => $request->input('kode'),
        ]);

        return redirect()->route('admin.programstudi')->with('success', 'Program Studi created successfully.');
    }

    // Show the form for editing an existing Program Studi
    public function editProgramStudi($id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        return view('edit_program_studi', compact('programStudi')); // Use this view for editing
    }

    // Update an existing Program Studi in the database
    public function updateProgramStudi(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:program_studi,kode,' . $id,
        ]);

        $programStudi = ProgramStudi::findOrFail($id);
        $programStudi->update([
            'name' => $request->input('name'),
            'kode' => $request->input('kode'),
        ]);

        return redirect()->route('admin.programstudi')->with('success', 'Program Studi updated successfully.');
    }

    // Delete a Program Studi from the database
    public function destroyProgramStudi($id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $programStudi->delete();

        return redirect()->route('admin.programstudi')->with('success', 'Program Studi deleted successfully.');
    }
}
