<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::latest()->get();
        return new Resource(true, 'List of schools', $schools);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required',
            'school_address' => 'required',
            'school_phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $school = School::create([
            'school_name' => $request->school_name,
            'school_address' => $request->school_address,
            'school_phone' => $request->school_phone,
            'school_capacity' => $request->school_capacity,
        ]);

        return new Resource(true, 'School created successfully', $school);
    }

    public function show($id)
    {
        $school = School::find($id);
        if (!$school) {
            return new Resource(false, 'School not found', null);
        }
        return new Resource(true, 'School details', $school);
    }

    public function update(Request $request, $id)
    {
        $school = School::find($id);
        if (!$school) {
            return new Resource(false, 'School not found', null);
        }

        $validator = Validator::make($request->all(), [
            'school_name' => 'required',
            'school_address' => 'required',
            'school_phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $school->update([
            'school_name' => $request->school_name,
            'school_address' => $request->school_address,
            'school_phone' => $request->school_phone,
            'school_capacity' => $request->school_capacity,
        ]);

        return new Resource(true, 'School updated successfully', $school);
    }

    public function destroy($id)
    {
        $school = School::find($id);
        if (!$school) {
            return new Resource(false, 'School not found', null);
        }
        $school->delete();
        return new Resource(true, 'School deleted successfully', null);
    }
}
