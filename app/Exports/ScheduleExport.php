<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduleExport implements FromArray, WithHeadings
{
    protected $mappedSchedule;

    public function __construct(array $mappedSchedule)
    {
        $this->mappedSchedule = $mappedSchedule;
    }

    public function array(): array
    {
        return $this->mappedSchedule;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jam', 'Mata Kuliah', 'Kelas', 'Ruangan'];
    }
}
