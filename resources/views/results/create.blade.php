{{-- resources/views/results/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-plus-circle me-2"></i>Add New Result
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-file-alt me-2"></i>Enter Student Result</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('results.store') }}" method="POST">
                @csrf
                
                <!-- Student & Subject Selection -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="student_id" class="form-label fw-bold">
                            <i class="fas fa-user-graduate text-primary me-2"></i>Student *
                        </label>
                        <select class="form-select form-select-lg @error('student_id') is-invalid @enderror" 
                                id="student_id" name="student_id" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->admission_number }} - {{ $student->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="subject_id" class="form-label fw-bold">
                            <i class="fas fa-book text-success me-2"></i>Subject *
                        </label>
                        <select class="form-select form-select-lg @error('subject_id') is-invalid @enderror" 
                                id="subject_id" name="subject_id" required>
                            <option value="">-- Select Subject --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Term & Session -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="term" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt text-info me-2"></i>Term *
                        </label>
                        <select class="form-select form-select-lg @error('term') is-invalid @enderror" 
                                id="term" name="term" required>
                            <option value="">-- Select Term --</option>
                            <option value="First Term" {{ old('term') == 'First Term' ? 'selected' : '' }}>First Term</option>
                            <option value="Second Term" {{ old('term') == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                            <option value="Third Term" {{ old('term') == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                        </select>
                        @error('term')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="session" class="form-label fw-bold">
                            <i class="fas fa-calendar-year text-warning me-2"></i>Academic Session *
                        </label>
                        <input type="text" class="form-control form-control-lg @error('session') is-invalid @enderror" 
                               id="session" name="session" value="{{ old('session') }}" 
                               placeholder="e.g., 2024/2025" required>
                        @error('session')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-4">

                <!-- CA Scores Section -->
                <h5 class="mb-3">
                    <i class="fas fa-clipboard-list text-primary me-2"></i>Continuous Assessment (CA) Scores
                </h5>
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-light border-primary">
                            <div class="card-body">
                                <label for="ca1_score" class="form-label fw-bold">
                                    <i class="fas fa-award text-primary me-2"></i>1st CA (Max: 10) *
                                </label>
                                <input type="number" class="form-control form-control-lg @error('ca1_score') is-invalid @enderror" 
                                       id="ca1_score" name="ca1_score" value="{{ old('ca1_score') }}" 
                                       min="0" max="10" step="0.01" required>
                                <small class="text-muted">Enter score between 0 and 10</small>
                                @error('ca1_score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-success">
                            <div class="card-body">
                                <label for="ca2_score" class="form-label fw-bold">
                                    <i class="fas fa-award text-success me-2"></i>2nd CA (Max: 10) *
                                </label>
                                <input type="number" class="form-control form-control-lg @error('ca2_score') is-invalid @enderror" 
                                       id="ca2_score" name="ca2_score" value="{{ old('ca2_score') }}" 
                                       min="0" max="10" step="0.01" required>
                                <small class="text-muted">Enter score between 0 and 10</small>
                                @error('ca2_score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-info">
                            <div class="card-body">
                                <label for="ca3_score" class="form-label fw-bold">
                                    <i class="fas fa-award text-info me-2"></i>3rd CA (Max: 10) *
                                </label>
                                <input type="number" class="form-control form-control-lg @error('ca3_score') is-invalid @enderror" 
                                       id="ca3_score" name="ca3_score" value="{{ old('ca3_score') }}" 
                                       min="0" max="10" step="0.01" required>
                                <small class="text-muted">Enter score between 0 and 10</small>
                                @error('ca3_score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Score -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-warning bg-opacity-10 border-warning">
                            <div class="card-body">
                                <label for="exam_score" class="form-label fw-bold">
                                    <i class="fas fa-pencil-alt text-warning me-2"></i>Exam Score (Max: 70) *
                                </label>
                                <input type="number" class="form-control form-control-lg @error('exam_score') is-invalid @enderror" 
                                       id="exam_score" name="exam_score" value="{{ old('exam_score') }}" 
                                       min="0" max="70" step="0.01" required>
                                <small class="text-muted">Enter exam score between 0 and 70</small>
                                @error('exam_score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Preview -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> Total score (100 marks), grade, and remark will be calculated automatically based on:
                    <ul class="mb-0 mt-2">
                        <li>CA Total: 1st CA + 2nd CA + 3rd CA = 30 marks</li>
                        <li>Exam: 70 marks</li>
                        <li><strong>Grand Total: 100 marks</strong></li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('results.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save Result
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<style>
.card {
    border-radius: 12px;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-2px);
}
.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
}
</style>