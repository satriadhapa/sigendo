<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\JamKuliah;
use App\Models\User;

class AdminController extends Controller
{
        // Fetch list of lecturers
    public function indexLecturers()
    {
        $lecturers = User::with('programStudi')->paginate(5); // Adjust role field if different
        return view('lecturersadmin', compact('lecturers'));
    }
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

    // Display the list of Mata Kuliah
    public function mataKuliah()
    {
        $mataKuliah = MataKuliah::with('programStudi')->paginate(5);
        $programStudies = ProgramStudi::all(); // Retrieve all Program Studi

        return view('matakuliah_admin', compact('mataKuliah', 'programStudies'));
    }

    // Show the form for creating a new Mata Kuliah
    public function createMataKuliah()
    {
        $programStudies = ProgramStudi::all();
        return view('create_matakuliah', compact('programStudies'));
    }

    // Store a newly created Mata Kuliah in the database
    public function storeMataKuliah(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|max:7',
            'kode' => 'required|string|max:10|unique:mata_kuliahs,kode',
            'program_studi_id' => 'required|exists:program_studi,id',
        ]);

        MataKuliah::create([
            'name' => $request->input('name'),
            'sks' => $request->input('sks'),
            'kode' => $request->input('kode'),
            'program_studi_id' => $request->input('program_studi_id'),
        ]);

        return redirect()->route('admin.matakuliah')->with('success', 'Mata Kuliah created successfully.');
    }

    // Show the form for editing an existing Mata Kuliah
    public function editMataKuliah($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $programStudies = ProgramStudi::all();
        return view('edit_matakuliah', compact('mataKuliah', 'programStudies'));
    }

    // Update an existing Mata Kuliah in the database
    public function updateMataKuliah(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sks' => 'required|string|max:7',
            'kode' => 'required|string|max:10|unique:mata_kuliahs,kode,' . $id,
            'program_studi_id' => 'required|exists:program_studi,id',
        ]);

        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->update([
            'name' => $request->input('name'),
            'sks' => $request->input('sks'),
            'kode' => $request->input('kode'),
            'program_studi_id' => $request->input('program_studi_id'),
        ]);

        return redirect()->route('admin.matakuliah')->with('success', 'Mata Kuliah updated successfully.');
    }
    public function mataKuliahByProgramStudi($id)
    {
        $programStudi = ProgramStudi::findOrFail($id); // Program Studi yang dipilih
        $mataKuliah = MataKuliah::where('program_studi_id', $id)->paginate(5); // Data Mata Kuliah berdasarkan Program Studi
        $programStudies = ProgramStudi::all(); // Semua Program Studi untuk pilihan di grid

        return view('matakuliah_admin', compact('mataKuliah', 'programStudies', 'programStudi'));
    }
    // Delete a Mata Kuliah from the database
    public function destroyMataKuliah($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->delete();

        return redirect()->route('admin.matakuliah')->with('success', 'Mata Kuliah deleted successfully.');
    }

    // Display list of Ruangan (Rooms)
    public function indexRuangan()
    {
        $rooms = Ruangan::paginate(5); // Paginated list of rooms
        return view('ruangan_admin', compact('rooms'));
    }

    // Show form to create a new Ruangan
    public function createRuangan()
    {
        return view('create_ruangan');
    }

    // Store a new Ruangan in the database
    public function storeRuangan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ruangan,name',
        ]);

        Ruangan::create($request->only(['name']));
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    // Show form to edit an existing Ruangan
    public function editRuangan($id)
    {
        $room = Ruangan::findOrFail($id);
        return view('edit_ruangan', compact('room'));
    }

    // Update an existing Ruangan in the database
    public function updateRuangan(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ruangan,name,'.$id
        ]);

        $room = Ruangan::findOrFail($id);
        $room->update($request->only(['name']));
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    // Delete a Ruangan from the database
    public function destroyRuangan($id)
    {
        $room = Ruangan::findOrFail($id);
        $room->delete();
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }

    
    // Display list of Jam Kuliah (Lecture Hours)
    public function indexJamKuliah()
    {
        $lectureHours = JamKuliah::paginate(5); // Adjust pagination as needed
        return view('jamkuliah_admin', compact('lectureHours'));
    }

    // Show form to create a new Jam Kuliah
    public function createJamKuliah()
    {
        return view('create_jam_kuliah');
    }

    public function storeJamKuliah(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        JamKuliah::create($request->only(['start_time', 'end_time']));
        return redirect()->route('admin.jamkuliah.index')->with('success', 'Jam Kuliah berhasil ditambahkan.');
    }

    // Show form to edit an existing Jam Kuliah
    public function editJamKuliah($id)
    {
        $lectureHour = JamKuliah::findOrFail($id);
        return view('edit_jam_kuliah', compact('lectureHour'));
    }

    // Update an existing Jam Kuliah in the database
    // Update an existing Jam Kuliah in the database
    public function updateJamKuliah(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $lectureHour = JamKuliah::findOrFail($id);

        // Check if data is received correctly
        $lectureHour->update($request->only(['start_time', 'end_time']));
        
        return redirect()->route('admin.jamkuliah.index')->with('success', 'Jam Kuliah berhasil diperbarui.');
    }

    // Delete a Jam Kuliah from the database
    public function destroyJamKuliah($id)
    {
        $lectureHour = JamKuliah::findOrFail($id);
        $lectureHour->delete();
        return redirect()->route('admin.jamkuliah.index')->with('success', 'Jam Kuliah berhasil dihapus.');
    }
}
