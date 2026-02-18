<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection
{
    protected $type;
    protected $school_id;
    protected $start;
    protected $end;

    public function __construct($type, $school_id = null, $start = null, $end)
    {
        $this->type = $type;
        $this->school_id = $school_id;
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = Attendance::with(['student', 'school']);

        // Filter berdasarkan school
        if ($this->school_id) {
            $query->where('school_id', $this->school_id);
        }

        // DAILY → Hari ini
        if ($this->type == 'daily') {
            $query->whereDate('attendance_date', Carbon::today());
        }

        // WEEKLY → Senin - Sabtu
        if ($this->type == 'weekly') {
            $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
            $end   = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(5);

            $query->whereBetween('attendance_date', [$start, $end]);
        }

        // MONTHLY → Bulan berjalan
        if ($this->type == 'monthly') {
            $query->whereMonth('attendance_date', Carbon::now()->month)
                  ->whereYear('attendance_date', Carbon::now()->year);
        }

        // RANGE → Custom date
        if ($this->type == 'range') {
            $query->whereBetween('attendance_date', [
                Carbon::parse($this->start),
                Carbon::parse($this->end)
            ]);
        }

        return $query->get()->map(function ($attendance) {
            return [
                'Student Name' => $attendance->student->student_name,
                'School'       => $attendance->school->school_name,
                'Class'        => $attendance->student->student_class,
                'Date'         => $attendance->attendance_date,
                'Time'         => $attendance->attendance_time,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'School',
            'Class',
            'Date',
            'Time',
        ];
    }
}
