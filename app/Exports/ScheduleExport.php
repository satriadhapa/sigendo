<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduleExport implements FromArray, WithHeadings
{
    protected $schedule;

    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    public function array(): array
    {
        return $this->schedule;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Hari',
            'Jam',
            'Kuliah',
            'Kelas',
        ];
    }
}
