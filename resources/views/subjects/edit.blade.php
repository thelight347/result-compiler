{{-- resources/views/subjects/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-book-open me-2"></i>Edit Subject
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-edit me-2"></i>Update Subject Information</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('subjects.update', $subject) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Subject Details Section -->
                <div class="mb-4 pb-3 border-bottom">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-book me-2"></i>Subject Details
                    </h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="code" class="form-label fw-bold">
                                <i class="fas fa-barcode text-primary me-2"></i>Subject Code *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code', $subject->code) }}" 
                                   placeholder="e.g., MATH101" 
                                   required>
                            <small class="text-muted">A unique code to identify this subject</small>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-book-open text-success me-2"></i>Subject Name *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $subject->name) }}" 
                                   placeholder="e.g., Mathematics" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="class" class="form-label fw-bold">
                                <i class="fas fa-school text-info me-2"></i>Class *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('class') is-invalid @enderror" 
                                   id="class" 
                                   name="class" 
                                   value="{{ old('class', $subject->class) }}" 
                                   placeholder="e.g., JSS 1, SSS 2" 
                                   required>
                            <small class="text-muted">Which class is this subject for?</small>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Subject Information Card -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="p-3">
                                    <i class="fas fa-code fa-3x text-primary mb-2"></i>
                                    <h6 class="mb-0">Code</h6>
                                    <p class="text-muted mb-0">{{ $subject->code }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center border-start">
                                <div class="p-3">
                                    <i class="fas fa-book fa-3x text-success mb-2"></i>
                                    <h6 class="mb-0">Subject</h6>
                                    <p class="text-muted mb-0">{{ $subject->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center border-start">
                                <div class="p-3">
                                    <i class="fas fa-users fa-3x text-info mb-2"></i>
                                    <h6 class="mb-0">Class</h6>
                                    <p class="text-muted mb-0">{{ $subject->class }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Box -->
                <div class="alert alert-warning d-flex align-items-center mb-4">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <strong>Important:</strong> Changing the subject code may affect existing results. 
                        Make sure you understand the impact before updating.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-save me-2"></i>Update Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

