{{-- resources/views/subjects/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-plus-circle me-2"></i>Add New Subject
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-book-medical me-2"></i>Create New Subject</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="code" class="form-label fw-bold">
                            <i class="fas fa-barcode text-primary me-2"></i>Subject Code *
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('code') is-invalid @enderror" 
                               id="code" 
                               name="code" 
                               value="{{ old('code') }}" 
                               placeholder="e.g., MATH101" 
                               required>
                        <small class="text-muted">Enter a unique code for this subject</small>
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
                               value="{{ old('name') }}" 
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
                               value="{{ old('class') }}" 
                               placeholder="e.g., JSS 1, SSS 2" 
                               required>
                        <small class="text-muted">Which class will study this subject?</small>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="fas fa-lightbulb fa-2x me-3"></i>
                    <div>
                        <strong>Tip:</strong> Make sure the subject code is unique and the class name matches existing class names in the system.
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-save me-2"></i>Add Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<style>
.card {
    border-radius: 12px;
}
.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
}
.btn-lg {
    padding: 12px 24px;
    font-size: 16px;
}
h6 {
    font-weight: 600;
}
</style>