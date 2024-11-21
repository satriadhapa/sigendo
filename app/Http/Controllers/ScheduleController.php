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
        $ruangan = Ruangan::all();

        return view('schedule.index', compact('mataKuliah', 'jamKuliah', 'ruangan'));
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
            // Cari nama mata kuliah berdasarkan ID
            $mataKuliahName = MataKuliah::find($entry['mata_kuliah'])->name ?? 'Unknown Mata Kuliah';
            // Cari nama jam kuliah berdasarkan ID
            $jamName = JamKuliah::find($entry['jam'])->start_time ?? 'Unknown Jam';
            $jamName2 = JamKuliah::find($entry['jam'])->end_time ?? 'Unknown Jam';
            // Cari nama ruangan berdasarkan ID
            $ruanganName = Ruangan::find($entry['ruangan'])->name ?? 'Unknown Ruangan';

            // Tambahkan hasil yang sudah dipetakan
            $mappedSchedule[] = [
                'tanggal' => $entry['tanggal'],
                'jam' => $jamName.' - '.$jamName2,  
                'mata_kuliah' => $mataKuliahName, 
                'kelas' => $entry['kelas'],
                'ruangan' => $ruanganName, 
            ];
        }

        // Tampilkan hasil dengan mappedSchedule
        return view('result', compact('mappedSchedule'));
    }
    /**
     * Export jadwal ke Excel
     */
    public function export()
    { 
            // Retrieve the mapped schedule from session
            $mappedSchedule = session('mappedSchedule', []);
        
            if (empty($mappedSchedule)) {
                return back()->with('error', 'Tidak ada jadwal untuk diekspor.');
            }
        
            // Prepare the data for export
            $exportData = [];
            foreach ($mappedSchedule as $entry) {
                $exportData[] = [
                    'Tanggal' => $entry['tanggal'],
                    'Jam' => $entry['jam'],
                    'Mata Kuliah' => $entry['mata_kuliah'],
                    'Kelas' => $entry['kelas'],
                    'Ruangan' => $entry['ruangan'],
                ];
            }
        
            // Export the schedule to Excel
            return Excel::download(new ScheduleExport($exportData), 'jadwal.xlsx');
        }
        
}
