<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-calendar-check me-2"></i>Attendance Management
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient d-flex justify-content-between align-items-center" 
             style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-list-check me-2"></i>Attendance Records</h5>
            <a href="{{ route('attendance.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-2"></i>Mark Attendance
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Term/Session</th>
                            <th class="text-center">Days Present</th>
                            <th class="text-center">Days Absent</th>
                            <th class="text-center">Total Days</th>
                            <th class="text-center">Percentage</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td class="fw-bold">{{ $attendance->student->full_name }}</td>
                            <td>{{ $attendance->student->class }}</td>
                            <td><small>{{ $attendance->term }} / {{ $attendance->session }}</small></td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ $attendance->days_present }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ $attendance->days_absent }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $attendance->total_days }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $percentage = $attendance->attendance_percentage;
                                @endphp
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar {{ $percentage >= 75 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                         style="width: {{ $percentage }}%">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No attendance records found</h5>
                                <a href="{{ route('attendance.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus me-2"></i>Mark First Attendance
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($attendances->hasPages())
        <div class="card-footer bg-light">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</x-app-layout>