{{-- resources/views/students/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-user-plus me-2"></i>Add New Student
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-id-card me-2"></i>Student Information</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="admission_number" class="form-label fw-bold">
                            <i class="fas fa-hashtag text-primary me-2"></i>Admission Number *
                        </label>
                        <input type="text" class="form-control form-control-lg @error('admission_number') is-invalid @enderror" 
                               id="admission_number" name="admission_number" value="{{ old('admission_number') }}" required>
                        @error('admission_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-bold">
                            <i class="fas fa-user text-success me-2"></i>First Name *
                        </label>
                        <input type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="middle_name" class="form-label fw-bold">
                            <i class="fas fa-user text-info me-2"></i>Middle Name
                        </label>
                        <input type="text" class="form-control form-control-lg" 
                               id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label fw-bold">
                            <i class="fas fa-user text-warning me-2"></i>Last Name *
                        </label>
                        <input type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" 
                               id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="gender" class="form-label fw-bold">
                            <i class="fas fa-venus-mars text-danger me-2"></i>Gender *
                        </label>
                        <select class="form-select form-select-lg @error('gender') is-invalid @enderror" 
                                id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="date_of_birth" class="form-label fw-bold">
                            <i class="fas fa-birthday-cake text-primary me-2"></i>Date of Birth *
                        </label>
                        <input type="date" class="form-control form-control-lg @error('date_of_birth') is-invalid @enderror" 
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="class" class="form-label fw-bold">
                            <i class="fas fa-school text-success me-2"></i>Class *
                        </label>
                        <input type="text" class="form-control form-control-lg @error('class') is-invalid @enderror" 
                               id="class" name="class" value="{{ old('class') }}" placeholder="e.g., JSS 1" required>
                        @error('class')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="section" class="form-label fw-bold">
                            <i class="fas fa-layer-group text-info me-2"></i>Section
                        </label>
                        <input type="text" class="form-control form-control-lg" 
                               id="section" name="section" value="{{ old('section') }}" placeholder="e.g., A">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>