<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Term Result / Report Card') }}
            </h2>
            <div class="flex space-x-2">
                <button onclick="window.print()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Print Report Card
                </button>
                <a href="{{ route('term-results.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Report Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="report-card">
                <div class="p-8">
                    <!-- School Header -->
                    <div class="text-center mb-8 border-b-2 border-gray-300 pb-6">
                        <h1 class="text-3xl font-bold text-gray-900">{{ config('app.name', 'School Name') }}</h1>
                        <p class="text-gray-600 mt-2">Address: School Address Line 1, City, State</p>
                        <p class="text-gray-600">Phone: +234 XXX XXX XXXX | Email: info@school.com</p>
                        <h2 class="text-xl font-semibold text-gray-800 mt-4">STUDENT REPORT CARD</h2>
                    </div>

                    <!-- Student Information -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Student Name:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $termResult->student->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Admission Number:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $termResult->student->admission_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Class:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $termResult->student->class }} {{ $termResult->student->section }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Term:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $termResult->term }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Session:</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $termResult->session }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Position in Class:</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $termResult->position }}{{ $termResult->position == 1 ? 'st' : ($termResult->position == 2 ? 'nd' : ($termResult->position == 3 ? 'rd' : 'th')) }}
                            </p>
                        </div>
                    </div>

                    <!-- Academic Performance -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Academic Performance</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">CA (40)</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Exam (60)</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Total (100)</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Grade</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($termResult->student->results()->where('term', $termResult->term)->where('session', $termResult->session)->get() as $result)
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2 text-sm font-medium text-gray-900">{{ $result->subject->name }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center text-sm text-gray-900">{{ $result->ca_score }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center text-sm text-gray-900">{{ $result->exam_score }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-900">{{ $result->total_score }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $result->grade === 'A' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $result->grade === 'B' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $result->grade === 'C' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ in_array($result->grade, ['D', 'E', 'F']) ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $result->grade }}
                                                </span>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $result->remarks ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-semibold">
                                        <td colspan="3" class="border border-gray-300 px-4 py-2 text-right">Total Score:</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ number_format($termResult->total_score, 2) }}</td>
                                        <td colspan="2" class="border border-gray-300 px-4 py-2"></td>
                                    </tr>
                                    <tr class="bg-gray-50 font-semibold">
                                        <td colspan="3" class="border border-gray-300 px-4 py-2 text-right">Average Score:</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ number_format($termResult->average_score, 2) }}%</td>
                                        <td colspan="2" class="border border-gray-300 px-4 py-2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Grading System -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Grading System</h3>
                        <div class="grid grid-cols-6 gap-2 text-sm">
                            <div class="bg-green-50 p-2 rounded"><strong>A:</strong> 70-100 (Excellent)</div>
                            <div class="bg-blue-50 p-2 rounded"><strong>B:</strong> 60-69 (Very Good)</div>
                            <div class="bg-yellow-50 p-2 rounded"><strong>C:</strong> 50-59 (Good)</div>
                            <div class="bg-orange-50 p-2 rounded"><strong>D:</strong> 45-49 (Pass)</div>
                            <div class="bg-red-50 p-2 rounded"><strong>E:</strong> 40-44 (Poor)</div>
                            <div class="bg-red-100 p-2 rounded"><strong>F:</strong> 0-39 (Fail)</div>
                        </div>
                    </div>

                    <!-- Comments and Remarks -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">Class Teacher's Remark:</h3>
                            <div class="border border-gray-300 p-3 rounded min-h-20 bg-gray-50">
                                {{ $termResult->teacher_comment ?? 'No comment provided.' }}
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">Principal's Remark:</h3>
                            <div class="border border-gray-300 p-3 rounded min-h-20 bg-gray-50">
                                {{ $termResult->principal_comment ?? 'No comment provided.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Signatures -->
                    <div class="grid grid-cols-3 gap-6 mt-8 pt-6 border-t border-gray-300">
                        <div class="text-center">
                            <div class="border-t border-gray-400 pt-2 mt-16">
                                <p class="text-sm font-semibold">Class Teacher's Signature</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="border-t border-gray-400 pt-2 mt-16">
                                <p class="text-sm font-semibold">Principal's Signature</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="border-t border-gray-400 pt-2 mt-16">
                                <p class="text-sm font-semibold">Date</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #report-card, #report-card * {
                visibility: visible;
            }
            #report-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</x-app-layout>