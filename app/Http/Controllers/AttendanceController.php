<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('student');

        if ($request->has('term')) {
            $query->where('term', $request->term);
        }

        if ($request->has('session')) {
            $query->where('session', $request->session);
        }

        $attendances = $query->latest()->paginate(20);
        
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $students = Student::all();
        return view('attendance.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'term' => 'required|string',
            'session' => 'required|string',
            'days_present' => 'required|integer|min:0',
            'days_absent' => 'required|integer|min:0',
            'total_days' => 'required|integer|min:1',
        ]);

        Attendance::create($validated);

        return redirect()->route('attendance.index')->with('success', 'Attendance record added successfully!');
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::all();
        return view('attendance.edit', compact('attendance', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'term' => 'required|string',
            'session' => 'required|string',
            'days_present' => 'required|integer|min:0',
            'days_absent' => 'required|integer|min:0',
            'total_days' => 'required|integer|min:1',
        ]);

        $attendance->update($validated);

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully!');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully!');
    }
}