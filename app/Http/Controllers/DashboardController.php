<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Result;
use App\Models\TermResult;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_subjects' => Subject::count(),
            'total_results' => Result::count(),
            'pending_approvals' => TermResult::where('is_approved', false)->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}