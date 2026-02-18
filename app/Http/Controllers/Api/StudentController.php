<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        // Code to list students
        $students = Student::with('school')->latest()->get();
        return new Resource(true, 'List of students', $students);
    }

    public function store(Request $request)
    {
        // Code to create a new student
        $validator = Validator::make($request->all(), [
            'fingerprint_id' => 'required',
            'student_name' => 'required',
            'student_address' => 'required',
            'student_phone' => 'required',
            'student_class' => 'required',
            'school_id' => 'required|exists:schools,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::create([
            'fingerprint_id' => $request->fingerprint_id,
            'student_name' => $request->student_name,
            'student_address' => $request->student_address,
            'student_phone' => $request->student_phone,
            'student_class' => $request->student_class,
            'school_id' => $request->school_id,
        ]);

        return new Resource(true, 'Student created successfully', $student);
    }

    public function show($id)
    {
        // Code to show a specific student
        $student = Student::with('school')->find($id);
        if (!$student) {
            return new Resource(false, 'Student not found', null);
        }
        return new Resource(true, 'Student details', $student);
    }

    public function update(Request $request, $id)
    {
        // Code to update a student
        $student = Student::find($id);
        if (!$student) {
            return new Resource(false, 'Student not found', null);
        }

        $validator = Validator::make($request->all(), [
            'fingerprint_id' => 'required',
            'student_name' => 'required',
            'student_address' => 'required',
            'student_phone' => 'required',
            'student_class' => 'required',
            'school_id' => 'required|exists:schools,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student->update([
            'fingerprint_id' => $request->fingerprint_id,
            'student_name' => $request->student_name,
            'student_address' => $request->student_address,
            'student_phone' => $request->student_phone,
            'student_class' => $request->student_class,
            'school_id' => $request->school_id,
        ]);

        return new Resource(true, 'Student updated successfully', $student);
    }

    public function destroy($id)
    {
        // Code to delete a student
        $student = Student::find($id);
        if (!$student) {
            return new Resource(false, 'Student not found', null);
        }
        $student->delete();
        return new Resource(true, 'Student deleted successfully', null);
    }
}
