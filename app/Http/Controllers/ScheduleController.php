<?php

namespace App\Http\Controllers;

use App\Services\SchedulingGeneticAlgorithm;
use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\JamKuliah;
use App\Models\Ruangan;
use App\Exports\ScheduleExport;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    /**
     * Menampilkan form pembuatan jadwal.
     */
    public function index()
    {
        // Ambil data dari database
        $mataKuliah = MataKuliah::all();
        $jamKuliah = JamKuliah::all();
        $ruangans = Ruangan::where('is_booked', false)->get();

        return view('schedule.index', compact('mataKuliah', 'jamKuliah', 'ruangans'));
    }

    /**
     * Menggenerate jadwal menggunakan algoritma genetika.
     */
    public function generate(Request $request)
    {
        // Validasi input dari pengguna
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'durasi_jadwal' => 'required|integer|min:1',
            'jumlah_populasi' => 'required|integer|min:1',
            'jumlah_generasi' => 'required|integer|min:1',
            'probabilitas_mutasi' => 'required|numeric|min:0|max:1',
            'mata_kuliah' => 'required|array|min:1',
            'jam_kuliah' => 'required|array|min:1',
            'ruangan' => 'required|array|min:1',
            'jumlah_kelas' => 'required|string', // Misalnya "A,B,C" untuk daftar kelas
        ]);
        
        // Tambahkan parameter ke service class
        $params = [
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'durasi_jadwal' => $validated['durasi_jadwal'],
            'jumlah_populasi' => $validated['jumlah_populasi'],
            'jumlah_generasi' => $validated['jumlah_generasi'],
            'probabilitas_mutasi' => $validated['probabilitas_mutasi'],
            'mata_kuliah' => $validated['mata_kuliah'],
            'jam_kuliah' => $validated['jam_kuliah'],
            'ruangan' => $validated['ruangan'],
            'jumlah_kelas' => $validated['jumlah_kelas'], // Daftar kelas
        ];

        // Jalankan algoritma genetika
        $scheduler = new SchedulingGeneticAlgorithm($params);
        $generatedSchedule = $scheduler->run();

        // Pemetaan ID ke nama atau value
        $mappedSchedule = [];
        foreach ($generatedSchedule as $entry) {
            $mataKuliahName = MataKuliah::find($entry['mata_kuliah'])->name ?? 'Unknown Mata Kuliah';
            $jamName = JamKuliah::find($entry['jam'])->start_time ?? 'Unknown Jam';
            $jamName2 = JamKuliah::find($entry['jam'])->end_time ?? 'Unknown Jam';
            $ruangan = Ruangan::find($entry['ruangan']);
            $tanggal = $entry['tanggal'];
            $hari = date('l', strtotime($tanggal)); // Mendapatkan nama hari berdasarkan tanggal
    
            $mappedSchedule[] = [
                'hari' => $hari,
                'tanggal' => $entry['tanggal'],
                'jam' => $jamName . ' - ' . $jamName2,
                'mata_kuliah' => $mataKuliahName,
                'kelas' => $entry['kelas'],
                'ruangan' => $ruangan->name ?? 'Unknown Ruangan',
                'ruangan_id' => $ruangan->id,
                'ruangan_is_booked' => $ruangan->is_booked ?? false,
            ];
        }

        session(['mappedSchedule' => $mappedSchedule]);

        return view('result', compact('mappedSchedule'));
    }
    public function showGeneratedSchedule()
    {
        // Ambil data jadwal dari session
        $mappedSchedule = session('mappedSchedule', []);

        if (empty($mappedSchedule)) {
            return redirect()->route('schedule.index')->with('error', 'Belum ada jadwal yang dihasilkan.');
        }

        return view('result', compact('mappedSchedule'));
    }
    public function approveRoom($ruangan_id)
    {
        // Cari ruangan berdasarkan ID
        $ruangan = Ruangan::findOrFail($ruangan_id);

        // Periksa apakah ruangan sudah disetujui
        if ($ruangan->is_booked) {
            return redirect()->back()->with('error', 'Ruangan sudah disetujui.');
        }

        // Tandai ruangan sebagai disetujui
        $ruangan->update(['is_booked' => true]);

        return redirect()->back()->with('success', 'Ruangan berhasil disetujui.');
    }
    public function approveAll()
    {
        // Ambil semua ruangan dari jadwal yang belum disetujui
        $mappedSchedule = session('mappedSchedule', []);

        // Loop dan setujui ruangan yang belum disetujui
        foreach ($mappedSchedule as &$entry) {
            if (!$entry['ruangan_is_booked']) {
                $ruangan = Ruangan::find($entry['ruangan_id']);
                if ($ruangan) {
                    $ruangan->is_booked = true;
                    $ruangan->save();
                }
                $entry['ruangan_is_booked'] = true; // Update status pada jadwal yang sudah ada
            }
        }

        // Simpan kembali update pada session
        session(['mappedSchedule' => $mappedSchedule]);

        return redirect()->route('schedule.result')->with('success', 'Semua ruangan berhasil disetujui!');
    }
    /**
     * Export jadwal ke Excel
     */
    public function export()
    {
        // Ambil data jadwal yang sudah di-generate
        $mappedSchedule = session('mappedSchedule', []);
        
        if (empty($mappedSchedule)) {
            return redirect()->route('user.dashboard.index')->with('error', 'Tidak ada jadwal untuk diekspor.');
        }

        // Ambil nama user (dari autentikasi atau session)
        $userName = auth()->user()->name ?? 'User'; // Jika menggunakan autentikasi

        // Format nama file dengan nama user
        $fileName = 'jadwal_' . str_replace(' ', '_', strtolower($userName)) . '.xlsx';

        // Ekspor ke Excel
        return Excel::download(new ScheduleExport($mappedSchedule), $fileName);
    }

        
}
