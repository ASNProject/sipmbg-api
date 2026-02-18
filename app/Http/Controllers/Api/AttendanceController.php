<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Http\Resources\Resource;


class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('student', 'school')->latest()->get();
        return new Resource(true, 'List of attendances', $attendances);
    }

    public function store($fingerprint_id)
    {
        $student = Student::where('fingerprint_id', $fingerprint_id)->first();

        if (!$student) {
            return response()->json([
                'success' => false, 
                'message' => 'Student not found'
            ], 404);
        }

        $today = Carbon::today()->toDateString();

        $existingAttendance = Attendance::where('student_id', $student->id)
            ->whereDate('attendance_date', $today)
            ->exists();

        if ($existingAttendance) {
            return response()->json([
                'success' => false, 
                'message' => 'Attendance already recorded for today'
            ], 400);
        }

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'school_id' => $student->school_id,
            'attendance_date' => Carbon::now()->toDateString(),
            'attendance_time' => Carbon::now()->toTimeString(),
        ]);

        return new Resource(true, 'Attendance recorded successfully', $attendance);
    }

    public function show($id)
    {
        $attendance = Attendance::with('student', 'school')->find($id);
        if (!$attendance) {
            return new Resource(false, 'Attendance not found', null);
        }
        return new Resource(true, 'Attendance details', $attendance);
    }

    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return new Resource(false, 'Attendance not found', null);
        }

        $attendance->delete();
        return new Resource(true, 'Attendance deleted successfully', null);
    }
}
