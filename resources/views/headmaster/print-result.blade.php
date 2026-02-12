<!DOCTYPE html>
<html>
<head>
    <title>Result Sheet - {{ $termResult->student->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .student-info table {
            width: 100%;
        }
        .student-info td {
            padding: 5px;
        }
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .results-table th, .results-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .results-table th {
            background-color: #f2f2f2;
        }
        .summary {
            margin-top: 20px;
        }
        .remarks {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-primary">Print Result</button>
        <a href="{{ route('headmaster.term-results') }}" class="btn btn-secondary">Back to Results</a>
    </div>

    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <h2>Student Report Card</h2>
        <p>{{ $termResult->term }} - {{ $termResult->session }}</p>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $termResult->student->full_name }}</td>
                <td><strong>Admission No:</strong></td>
                <td>{{ $termResult->student->admission_number }}</td>
            </tr>
            <tr>
                <td><strong>Class:</strong></td>
                <td>{{ $termResult->student->class }}</td>
                <td><strong>Gender:</strong></td>
                <td>{{ ucfirst($termResult->student->gender) }}</td>
            </tr>
        </table>
    </div>

    <table class="results-table">
        <thead>
            <tr>
                <th>Subject</th>
                <th>CA Total (40)</th>
                <th>Exam (60)</th>
                <th>Total (100)</th>
                <th>Grade</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result->subject->name }}</td>
                <td>{{ $result->ca1_score + $result->ca2_score + $result->ca3_score }}</td>
                <td>{{ $result->exam_score }}</td>
                <td><strong>{{ $result->total_score }}</strong></td>
                <td>{{ $result->grade }}</td>
                <td>{{ $result->remark }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table style="width: 50%;">
            <tr>
                <td><strong>Average Score:</strong></td>
                <td>{{ number_format($termResult->average_score, 2) }}</td>
            </tr>
            <tr>
                <td><strong>GPA:</strong></td>
                <td>{{ number_format($termResult->gpa, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Position in Class:</strong></td>
                <td>{{ $termResult->position }}{{ $termResult->position == 1 ? 'st' : ($termResult->position == 2 ? 'nd' : ($termResult->position == 3 ? 'rd' : 'th')) }}</td>
            </tr>
        </table>
    </div>

    @if($attendance)
    <div class="summary">
        <h4>Attendance</h4>
        <table style="width: 50%;">
            <tr>
                <td><strong>Days Present:</strong></td>
                <td>{{ $attendance->days_present }}</td>
            </tr>
            <tr>
                <td><strong>Days Absent:</strong></td>
                <td>{{ $attendance->days_absent }}</td>
            </tr>
            <tr>
                <td><strong>Total Days:</strong></td>
                <td>{{ $attendance->total_days }}</td>
            </tr>
            <tr>
                <td><strong>Percentage:</strong></td>
                <td>{{ $attendance->attendance_percentage }}%</td>
            </tr>
        </table>
    </div>
    @endif

    <div class="remarks">
        <p><strong>Class Teacher's Remark:</strong></p>
        <p>{{ $termResult->teacher_remark }}</p>
    </div>

    <div class="remarks">
        <p><strong>Headmaster's Remark:</strong></p>
        <p>{{ $termResult->headmaster_remark ?? 'Not yet provided' }}</p>
    </div>

    <div style="margin-top: 50px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <p>_________________________</p>
                    <p>Class Teacher's Signature</p>
                </td>
                <td style="width: 50%; text-align: right;">
                    <p>_________________________</p>
                    <p>Headmaster's Signature</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>