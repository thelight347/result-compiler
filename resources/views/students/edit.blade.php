{{-- resources/views/students/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-user-edit me-2"></i>Edit Student
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-id-card me-2"></i>Update Student Information</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <div class="mb-4 pb-3 border-bottom">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-user-circle me-2"></i>Personal Information
                    </h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="admission_number" class="form-label fw-bold">
                                <i class="fas fa-hashtag text-primary me-2"></i>Admission Number *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('admission_number') is-invalid @enderror" 
                                   id="admission_number" 
                                   name="admission_number" 
                                   value="{{ old('admission_number', $student->admission_number) }}" 
                                   required>
                            @error('admission_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="first_name" class="form-label fw-bold">
                                <i class="fas fa-user text-success me-2"></i>First Name *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('first_name') is-invalid @enderror" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name', $student->first_name) }}" 
                                   required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="middle_name" class="form-label fw-bold">
                                <i class="fas fa-user text-info me-2"></i>Middle Name
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="middle_name" 
                                   name="middle_name" 
                                   value="{{ old('middle_name', $student->middle_name) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="form-label fw-bold">
                                <i class="fas fa-user text-warning me-2"></i>Last Name *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('last_name') is-invalid @enderror" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name', $student->last_name) }}" 
                                   required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gender" class="form-label fw-bold">
                                <i class="fas fa-venus-mars text-danger me-2"></i>Gender *
                            </label>
                            <select class="form-select form-select-lg @error('gender') is-invalid @enderror" 
                                    id="gender" 
                                    name="gender" 
                                    required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label fw-bold">
                                <i class="fas fa-birthday-cake text-primary me-2"></i>Date of Birth *
                            </label>
                            <input type="date" 
                                   class="form-control form-control-lg @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" 
                                   name="date_of_birth" 
                                   value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}" 
                                   required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="mb-4">
                    <h6 class="text-success mb-3">
                        <i class="fas fa-graduation-cap me-2"></i>Academic Information
                    </h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="class" class="form-label fw-bold">
                                <i class="fas fa-school text-success me-2"></i>Class *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('class') is-invalid @enderror" 
                                   id="class" 
                                   name="class" 
                                   value="{{ old('class', $student->class) }}" 
                                   placeholder="e.g., JSS 1" 
                                   required>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="section" class="form-label fw-bold">
                                <i class="fas fa-layer-group text-info me-2"></i>Section
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="section" 
                                   name="section" 
                                   value="{{ old('section', $student->section) }}" 
                                   placeholder="e.g., A">
                        </div>
                    </div>
                </div>

                <!-- Alert Box -->
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="fas fa-info-circle fa-2x me-3"></i>
                    <div>
                        <strong>Note:</strong> Make sure all required fields are filled correctly before updating.
                        Changes will be saved immediately.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-save me-2"></i>Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>