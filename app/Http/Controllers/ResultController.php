<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Result::with(['student', 'subject', 'teacher']);

        if ($request->has('term')) {
            $query->where('term', $request->term);
        }

        if ($request->has('session')) {
            $query->where('session', $request->session());
        }

        if ($request->has('class')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class', $request->class);
            });
        }

        $results = $query->latest()->paginate(20);
        
        return view('results.index', compact('results'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        
        return view('results.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|exists:students,id',
        'subject_id' => 'required|exists:subjects,id',
        'term' => 'required|string',
        'session' => 'required|string',
        'ca1_score' => 'required|numeric|min:0|max:10',
        'ca2_score' => 'required|numeric|min:0|max:10',
        'ca3_score' => 'required|numeric|min:0|max:10',
        'exam_score' => 'required|numeric|min:0|max:70',
    ]);

    $result = new Result($validated);
    $result->teacher_id = auth()->id();
    $result->calculateTotal();
    $result->calculateGrade();
    $result->save();

    return redirect()->route('results.index')->with('success', 'Result added successfully!');
}

    public function show(Result $result)
    {
        $result->load(['student', 'subject', 'teacher']);
        return view('results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        // Only allow editing if not locked
        if ($result->is_locked) {
            return redirect()->route('results.index')
                ->with('error', 'This result is locked and cannot be edited.');
        }

        $students = Student::all();
        $subjects = Subject::all();
        
        return view('results.edit', compact('result', 'students', 'subjects'));
    }

    public function update(Request $request, Result $result)
{
    if ($result->is_locked) {
        return redirect()->route('results.index')->with('error', 'This result is locked!');
    }

    $validated = $request->validate([
        'student_id' => 'required|exists:students,id',
        'subject_id' => 'required|exists:subjects,id',
        'term' => 'required|string',
        'session' => 'required|string',
        'ca1_score' => 'required|numeric|min:0|max:10',
        'ca2_score' => 'required|numeric|min:0|max:10',
        'ca3_score' => 'required|numeric|min:0|max:10',
        'exam_score' => 'required|numeric|min:0|max:70',
    ]);

    $result->update($validated);
    $result->calculateTotal();
    $result->calculateGrade();
    $result->save();

    return redirect()->route('results.index')->with('success', 'Result updated successfully!');
}

    public function destroy(Result $result)
    {
        if ($result->is_locked) {
            return redirect()->route('results.index')
                ->with('error', 'This result is locked and cannot be deleted.');
        }

        $result->delete();

        return redirect()->route('results.index')
            ->with('success', 'Result deleted successfully.');
    }

    public function lock(Result $result)
    {
        $result->update([
            'is_locked' => true,
            'locked_at' => now(),
        ]);

        return back()->with('success', 'Result locked successfully.');
    }

    public function release(Result $result)
    {
        $result->update([
            'is_released' => true,
            'released_at' => now(),
        ]);

        return back()->with('success', 'Result released successfully.');
    }

    public function bulkUpload()
{
    $students = Student::all();
    $subjects = Subject::all();
    
    return view('results.bulk-upload', compact('students', 'subjects'));
}

public function storeBulk(Request $request)
{
    $request->validate([
        'term' => 'required|string',
        'session' => 'required|string',
        'class' => 'required|string',
        'results' => 'required|array',
        'results.*.student_id' => 'required|exists:students,id',
        'results.*.subject_id' => 'required|exists:subjects,id',
        'results.*.ca1_score' => 'required|numeric|min:0|max:10',
        'results.*.ca2_score' => 'required|numeric|min:0|max:10',
        'results.*.ca3_score' => 'required|numeric|min:0|max:10',
        'results.*.exam_score' => 'required|numeric|min:0|max:70',
    ]);

    $created = 0;
    
    foreach ($request->results as $resultData) {
        // Calculate test score (CA total)
        $testScore = $resultData['ca1_score'] + $resultData['ca2_score'] + $resultData['ca3_score'];
        
        $result = Result::create([
            'student_id' => $resultData['student_id'],
            'subject_id' => $resultData['subject_id'],
            'teacher_id' => auth()->id(),
            'term' => $request->term,
            'session' => $request->session,
            'test_score' => $testScore,
            'exam_score' => $resultData['exam_score'],
        ]);
        
        $result->calculateTotal();
        $result->calculateGrade();
        $result->save();
        
        $created++;
    }

    return redirect()->route('results.index')
        ->with('success', "{$created} results uploaded successfully!");
}
}