<?php

namespace App\Http\Controllers;

use App\Models\TermResult;
use App\Models\Student;
use App\Models\Result;
use Illuminate\Http\Request;

class TermResultController extends Controller
{
    public function index(Request $request)
    {
        $query = TermResult::with(['student', 'approvedBy']);

        if ($request->has('term')) {
            $query->where('term', $request->term);
        }

        if ($request->has('session')) {
            $query->where('session', $request->session);
        }

        $termResults = $query->latest()->paginate(20);
        
        return view('term-results.index', compact('termResults'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'term' => 'required|string',
            'session' => 'required|string',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        
        // Get all results for this student in the term/session
        $results = Result::where('student_id', $student->id)
            ->where('term', $validated['term'])
            ->where('session', $validated['session'])
            ->get();

        if ($results->isEmpty()) {
            return back()->with('error', 'No results found for this student in the selected term/session.');
        }

        $totalScore = $results->sum('total_score');
        $averageScore = $results->avg('total_score');
        
        // Calculate GPA (assuming 4.0 scale)
        $gpa = $this->calculateGPA($averageScore);

        $termResult = TermResult::updateOrCreate(
            [
                'student_id' => $student->id,
                'term' => $validated['term'],
                'session' => $validated['session'],
            ],
            [
                'total_score' => $totalScore,
                'average_score' => $averageScore,
                'gpa' => $gpa,
            ]
        );

        return redirect()->route('term-results.show', $termResult)
            ->with('success', 'Term result generated successfully.');
    }

    public function show(TermResult $termResult)
    {
        $termResult->load(['student', 'approvedBy']);
        
        // Get individual subject results
        $results = Result::where('student_id', $termResult->student_id)
            ->where('term', $termResult->term)
            ->where('session', $termResult->session)
            ->with('subject')
            ->get();

        return view('term-results.show', compact('termResult', 'results'));
    }

    public function approve(TermResult $termResult)
    {
        if (!auth()->user()->isHeadmaster()) {
            return back()->with('error', 'Only headmaster can approve results.');
        }

        $termResult->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Term result approved successfully.');
    }

    public function backup(TermResult $termResult)
    {
        $termResult->update([
            'is_backed_up' => true,
            'backed_up_at' => now(),
        ]);

        return back()->with('success', 'Term result backed up successfully.');
    }

    private function calculateGPA($averageScore)
    {
        if ($averageScore >= 90) return 4.0;
        if ($averageScore >= 80) return 3.5;
        if ($averageScore >= 70) return 3.0;
        if ($averageScore >= 60) return 2.5;
        if ($averageScore >= 50) return 2.0;
        return 1.0;
    }
}