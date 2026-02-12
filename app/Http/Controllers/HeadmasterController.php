<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\TermResult;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeadmasterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isHeadmaster()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function pendingResults()
    {
        $results = Result::with(['student', 'subject', 'teacher'])
            ->where('is_released', false)
            ->latest()
            ->paginate(20);

        return view('headmaster.pending-results', compact('results'));
    }

    public function releaseResult(Result $result)
    {
        $result->update([
            'is_released' => true,
            'released_at' => now(),
        ]);

        return back()->with('success', 'Result released successfully!');
    }

    public function lockResult(Result $result)
    {
        $result->update([
            'is_locked' => true,
            'locked_at' => now(),
        ]);

        return back()->with('success', 'Result locked successfully!');
    }

    public function unlockResult(Result $result)
    {
        $result->update([
            'is_locked' => false,
            'locked_at' => null,
        ]);

        return back()->with('success', 'Result unlocked successfully!');
    }

    public function termResults(Request $request)
    {
        $query = TermResult::with(['student', 'approvedBy']);

        if ($request->has('term')) {
            $query->where('term', $request->term);
        }

        if ($request->has('session')) {
            $query->where('session', $request->session);
        }

        $termResults = $query->latest()->paginate(20);

        return view('headmaster.term-results', compact('termResults'));
    }

    public function compileTermResult(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'term' => 'required|string',
            'session' => 'required|string',
        ]);

        $student = Student::findOrFail($request->student_id);
        
        // Get all results for this student in this term
        $results = Result::where('student_id', $student->id)
            ->where('term', $request->term)
            ->where('session', $request->session)
            ->where('is_released', true)
            ->get();

        if ($results->isEmpty()) {
            return back()->with('error', 'No released results found for this student!');
        }

        // Calculate totals
        $totalScore = $results->sum('total_score');
        $averageScore = $results->avg('total_score');
        
        // Calculate GPA (simplified: A+=4.0, A=3.7, B=3.0, C=2.0, D=1.0, F=0.0)
        $gradePoints = [
            'A+' => 4.0,
            'A' => 3.7,
            'B' => 3.0,
            'C' => 2.0,
            'D' => 1.0,
            'F' => 0.0,
        ];
        
        $gpa = $results->sum(function ($result) use ($gradePoints) {
            return $gradePoints[$result->grade] ?? 0;
        }) / $results->count();

        // Calculate position in class
        $classStudents = Student::where('class', $student->class)->pluck('id');
        $classAverages = [];
        
        foreach ($classStudents as $studentId) {
            $studentResults = Result::where('student_id', $studentId)
                ->where('term', $request->term)
                ->where('session', $request->session)
                ->where('is_released', true)
                ->get();
            
            if ($studentResults->isNotEmpty()) {
                $classAverages[$studentId] = $studentResults->avg('total_score');
            }
        }
        
        arsort($classAverages);
        $position = array_search($student->id, array_keys($classAverages)) + 1;

        // Get or create attendance
        $attendance = Attendance::firstOrCreate(
            [
                'student_id' => $student->id,
                'term' => $request->term,
                'session' => $request->session,
            ],
            [
                'days_present' => 0,
                'days_absent' => 0,
                'total_days' => 0,
            ]
        );

        // Create or update term result
        $termResult = TermResult::updateOrCreate(
            [
                'student_id' => $student->id,
                'term' => $request->term,
                'session' => $request->session,
            ],
            [
                'total_score' => $totalScore,
                'average_score' => $averageScore,
                'gpa' => round($gpa, 2),
                'position' => $position,
                'teacher_remark' => $this->generateRemark($averageScore),
            ]
        );

        return back()->with('success', 'Term result compiled successfully!');
    }

    public function approveTermResult(TermResult $termResult)
    {
        $termResult->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Term result approved successfully!');
    }

    public function addHeadmasterRemark(Request $request, TermResult $termResult)
    {
        $request->validate([
            'headmaster_remark' => 'required|string',
        ]);

        $termResult->update([
            'headmaster_remark' => $request->headmaster_remark,
        ]);

        return back()->with('success', 'Remark added successfully!');
    }

    public function backupToGoogleDrive(TermResult $termResult)
    {
        try {
            // Generate JSON data
            $data = [
                'student' => $termResult->student->full_name,
                'admission_number' => $termResult->student->admission_number,
                'class' => $termResult->student->class,
                'term' => $termResult->term,
                'session' => $termResult->session,
                'average_score' => $termResult->average_score,
                'gpa' => $termResult->gpa,
                'position' => $termResult->position,
                'results' => Result::where('student_id', $termResult->student_id)
                    ->where('term', $termResult->term)
                    ->where('session', $termResult->session)
                    ->with('subject')
                    ->get()
                    ->toArray(),
            ];

            // Save to local storage (as Google Drive might not be configured)
            $filename = sprintf(
                '%s_%s_%s_%s.json',
                $termResult->student->admission_number,
                $termResult->session,
                $termResult->term,
                date('Y-m-d')
            );

            // Try Google Drive, fallback to local
            try {
                Storage::disk('google')->put($filename, json_encode($data, JSON_PRETTY_PRINT));
            } catch (\Exception $e) {
                // Fallback to local storage
                Storage::disk('local')->put('backups/' . $filename, json_encode($data, JSON_PRETTY_PRINT));
            }

            $termResult->update([
                'is_backed_up' => true,
                'backed_up_at' => now(),
            ]);

            return back()->with('success', 'Result backed up successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    private function generateRemark($average)
    {
        if ($average >= 90) {
            return 'Outstanding performance! Keep up the excellent work.';
        } elseif ($average >= 80) {
            return 'Very good performance. Continue working hard.';
        } elseif ($average >= 70) {
            return 'Good performance. There is room for improvement.';
        } elseif ($average >= 60) {
            return 'Fair performance. More effort is needed.';
        } elseif ($average >= 50) {
            return 'Below average performance. Serious improvement needed.';
        } else {
            return 'Poor performance. Requires urgent attention and extra support.';
        }
    }

    public function printResult(TermResult $termResult)
    {
        $results = Result::where('student_id', $termResult->student_id)
            ->where('term', $termResult->term)
            ->where('session', $termResult->session)
            ->with('subject')
            ->get();

        $attendance = Attendance::where('student_id', $termResult->student_id)
            ->where('term', $termResult->term)
            ->where('session', $termResult->session)
            ->first();

        return view('headmaster.print-result', compact('termResult', 'results', 'attendance'));
    }
}