<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleExport implements FromView
{
    protected $schedule;

    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    public function view(): View
    {
        return view('exports.schedule', ['mappedSchedule' => $this->schedule]);
    }
}
