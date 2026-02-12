<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-2.5 rounded-lg shadow-md">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Edit Result</h2>
                    <p class="text-xs text-gray-500">Update student performance record</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('results.update', $result) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Student & Subject Info (Read-only) -->
                        <div class="mb-6">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Student -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Student</label>
                                        <p class="text-base font-bold text-gray-900">{{ $result->student->full_name }}</p>
                                        <input type="hidden" name="student_id" value="{{ $result->student_id }}">
                                    </div>

                                    <!-- Subject -->
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Subject</label>
                                        <p class="text-base font-bold text-gray-900">{{ $result->subject->name }}</p>
                                        <input type="hidden" name="subject_id" value="{{ $result->subject_id }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Session -->
                        <div class="mb-6">
                            <div class="flex items-center mb-4 pb-2 border-b-2 border-purple-100">
                                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-gray-800">Academic Session</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Term -->
                                <div>
                                    <label for="term" class="block text-sm font-medium text-gray-700 mb-1">
                                        Term <span class="text-red-500">*</span>
                                    </label>
                                    <select name="term" id="term" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition text-sm" required>
                                        <option value="">Select Term</option>
                                        <option value="First Term" {{ old('term', $result->term) == 'First Term' ? 'selected' : '' }}>First Term</option>
                                        <option value="Second Term" {{ old('term', $result->term) == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                                        <option value="Third Term" {{ old('term', $result->term) == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                                    </select>
                                    @error('term')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Session -->
                                <div>
                                    <label for="session" class="block text-sm font-medium text-gray-700 mb-1">
                                        Session <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="session" id="session" 
                                        value="{{ old('session', $result->session) }}" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition text-sm" 
                                        placeholder="e.g., 2023/2024" required>
                                    @error('session')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Score Entry -->
                        <div class="mb-6">
                            <div class="flex items-center mb-4 pb-2 border-b-2 border-yellow-100">
                                <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-gray-800">Score Entry</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- CA Score -->
                                <div>
                                    <label for="ca_score" class="block text-sm font-medium text-gray-700 mb-1">
                                        CA Score <span class="text-red-500">*</span>
                                        <span class="text-gray-400 text-xs">(0-40)</span>
                                    </label>
                                    <input type="number" name="ca_score" id="ca_score" 
                                        value="{{ old('ca_score', $result->ca_score) }}" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition text-sm" 
                                        min="0" max="40" step="0.01" required>
                                    @error('ca_score')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Exam Score -->
                                <div>
                                    <label for="exam_score" class="block text-sm font-medium text-gray-700 mb-1">
                                        Exam Score <span class="text-red-500">*</span>
                                        <span class="text-gray-400 text-xs">(0-60)</span>
                                    </label>
                                    <input type="number" name="exam_score" id="exam_score" 
                                        value="{{ old('exam_score', $result->exam_score) }}" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm" 
                                        min="0" max="60" step="0.01" required>
                                    @error('exam_score')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Live Score Display -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 border-2 border-green-200">
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <p class="text-xs font-medium text-gray-600 mb-1">Total Score</p>
                                        <p class="text-2xl font-bold text-green-600" id="totalScore">{{ $result->total_score }}</p>
                                        <p class="text-xs text-gray-500">out of 100</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-600 mb-1">Grade</p>
                                        <p class="text-2xl font-bold" id="gradeLetter">
                                            <span class="
                                                {{ $result->grade === 'A' ? 'text-green-600' : '' }}
                                                {{ $result->grade === 'B' ? 'text-blue-600' : '' }}
                                                {{ $result->grade === 'C' ? 'text-yellow-600' : '' }}
                                                {{ in_array($result->grade, ['D', 'E', 'F']) ? 'text-red-600' : '' }}
                                            ">{{ $result->grade }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500" id="gradeRemark">
                                            {{ $result->grade === 'A' ? 'Excellent' : ($result->grade === 'B' ? 'Very Good' : ($result->grade === 'C' ? 'Good' : 'Needs Improvement')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="mb-6">
                            <div class="flex items-center mb-4 pb-2 border-b-2 border-gray-100">
                                <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-gray-800">Remarks</h3>
                            </div>

                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">
                                    Teacher's Remarks <span class="text-gray-400 text-xs">(Optional)</span>
                                </label>
                                <textarea name="remarks" id="remarks" rows="3" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition text-sm resize-none" 
                                    placeholder="Enter any remarks...">{{ old('remarks', $result->remarks) }}</textarea>
                                @error('remarks')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('results.index') }}" 
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition text-sm">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-lg transition shadow-md hover:shadow-lg text-sm">
                                Update Result
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live calculation of total score and grade
        const caInput = document.getElementById('ca_score');
        const examInput = document.getElementById('exam_score');
        const totalDisplay = document.getElementById('totalScore');
        const gradeLetterDisplay = document.getElementById('gradeLetter').querySelector('span');
        const gradeRemarkDisplay = document.getElementById('gradeRemark');

        function calculateGrade(total) {
            if (total >= 70) return { letter: 'A', remark: 'Excellent', color: 'text-green-600' };
            if (total >= 60) return { letter: 'B', remark: 'Very Good', color: 'text-blue-600' };
            if (total >= 50) return { letter: 'C', remark: 'Good', color: 'text-yellow-600' };
            if (total >= 45) return { letter: 'D', remark: 'Pass', color: 'text-orange-600' };
            if (total >= 40) return { letter: 'E', remark: 'Poor', color: 'text-red-600' };
            return { letter: 'F', remark: 'Fail', color: 'text-red-600' };
        }

        function updateScore() {
            const ca = parseFloat(caInput.value) || 0;
            const exam = parseFloat(examInput.value) || 0;
            const total = ca + exam;
            const grade = calculateGrade(total);

            totalDisplay.textContent = total.toFixed(2);
            gradeLetterDisplay.textContent = grade.letter;
            gradeLetterDisplay.className = grade.color;
            gradeRemarkDisplay.textContent = grade.remark;
        }

        caInput.addEventListener('input', updateScore);
        examInput.addEventListener('input', updateScore);
    </script>
</x-app-layout>