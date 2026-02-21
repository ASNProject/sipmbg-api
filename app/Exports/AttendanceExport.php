<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $type;
    protected $school_id;
    protected $start;
    protected $end;

    public function __construct($type, $school_id = null, $start = null, $end = null)
    {
        $this->type = $type;
        $this->school_id = $school_id;
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = Attendance::with(['student', 'school']);

        if ($this->school_id) {
            $query->where('school_id', $this->school_id);
        }

        if ($this->type == 'daily') {
            $query->whereDate('attendance_date', Carbon::today());
        }

        if ($this->type == 'weekly') {
            $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
            $end   = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(5);

            $query->whereBetween('attendance_date', [$start, $end]);
        }

        if ($this->type == 'monthly') {
            $query->whereMonth('attendance_date', Carbon::now()->month)
                  ->whereYear('attendance_date', Carbon::now()->year);
        }

        if ($this->type == 'range') {
            $query->whereBetween('attendance_date', [
                Carbon::parse($this->start),
                Carbon::parse($this->end)
            ]);
        }

        return $query->get()->map(function ($attendance) {
            return [
                $attendance->student->student_name,
                $attendance->school->school_name,
                $attendance->student->student_class,
                $attendance->attendance_date,
                $attendance->attendance_time,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Sekolah',
            'Kelas',
            'Tanggal ',
            'Waktu',
        ];
    }
}