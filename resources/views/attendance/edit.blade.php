<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-edit me-2"></i>Edit Attendance
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-clipboard-check me-2"></i>Update Attendance Record</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('attendance.update', $attendance) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="student_id" class="form-label fw-bold">
                            <i class="fas fa-user-graduate text-primary me-2"></i>Student *
                        </label>
                        <select class="form-select form-select-lg @error('student_id') is-invalid @enderror" 
                                id="student_id" name="student_id" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->admission_number }} - {{ $student->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="term" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt text-info me-2"></i>Term *
                        </label>
                        <select class="form-select form-select-lg @error('term') is-invalid @enderror" id="term" name="term" required>
                            <option value="">-- Select Term --</option>
                            <option value="First Term" {{ $attendance->term == 'First Term' ? 'selected' : '' }}>First Term</option>
                            <option value="Second Term" {{ $attendance->term == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                            <option value="Third Term" {{ $attendance->term == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                        </select>
                        @error('term')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="session" class="form-label fw-bold">
                            <i class="fas fa-calendar-year text-warning me-2"></i>Session *
                        </label>
                        <input type="text" class="form-control form-control-lg @error('session') is-invalid @enderror" 
                               id="session" name="session" value="{{ $attendance->session }}" placeholder="e.g., 2024/2025" required>
                        @error('session')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3"><i class="fas fa-chart-bar text-success me-2"></i>Attendance Statistics</h5>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-success bg-opacity-10 border-success">
                            <div class="card-body">
                                <label for="days_present" class="form-label fw-bold">
                                    <i class="fas fa-check-circle text-success me-2"></i>Days Present *
                                </label>
                                <input type="number" class="form-control form-control-lg @error('days_present') is-invalid @enderror" 
                                       id="days_present" name="days_present" value="{{ $attendance->days_present }}" min="0" required>
                                @error('days_present')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-danger bg-opacity-10 border-danger">
                            <div class="card-body">
                                <label for="days_absent" class="form-label fw-bold">
                                    <i class="fas fa-times-circle text-danger me-2"></i>Days Absent *
                                </label>
                                <input type="number" class="form-control form-control-lg @error('days_absent') is-invalid @enderror" 
                                       id="days_absent" name="days_absent" value="{{ $attendance->days_absent }}" min="0" required>
                                @error('days_absent')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body">
                                <label for="total_days" class="form-label fw-bold">
                                    <i class="fas fa-calendar text-primary me-2"></i>Total School Days *
                                </label>
                                <input type="number" class="form-control form-control-lg @error('total_days') is-invalid @enderror" 
                                       id="total_days" name="total_days" value="{{ $attendance->total_days }}" min="1" required>
                                @error('total_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Current Attendance Percentage: <strong>{{ $attendance->attendance_percentage }}%</strong>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('attendance.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Update Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>