<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceExportController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:daily,weekly,monthly,range',
            'start' => 'required_if:type,range|date',
            'end'   => 'required_if:type,range|date|after_or_equal:start',
            'school_id' => 'nullable|exists:schools,id'
        ]);

        $fileName = 'attendance_'.$request->type.'_'.now()->format('YmdHis').'.xlsx';

        return Excel::download(
            new AttendanceExport(
                $request->type,
                $request->school_id,
                $request->start,
                $request->end
            ),
            $fileName
        );
    }
}
