<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'school_id',
        'attendance_date',
        'attendance_time',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function getAttendanceDateAttribute($value)
    {
        if (!$value) return null;

        return Carbon::parse($value)
            ->locale('id')
            ->translatedFormat('d F Y'); 
    }

    public function getAttendanceTimeAttribute($value)
    {
        if (!$value) return null;

        return Carbon::parse($value)
            ->format('H:i') . ' WIB';
    }
}