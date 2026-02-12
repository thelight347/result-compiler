{{-- resources/views/students/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-users me-2"></i>Students Management
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient d-flex justify-content-between align-items-center" 
             style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-user-graduate me-2"></i>All Students</h5>
            <a href="{{ route('students.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-2"></i>Add New Student
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Admission No.</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Class</th>
                            <th>Date of Birth</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td><span class="badge bg-primary">{{ $student->admission_number }}</span></td>
                            <td class="fw-bold">{{ $student->full_name }}</td>
                            <td>
                                <i class="fas fa-{{ $student->gender == 'male' ? 'mars text-primary' : 'venus text-danger' }} me-1"></i>
                                {{ ucfirst($student->gender) }}
                            </td>
                            <td><span class="badge bg-info">{{ $student->class }} {{ $student->section }}</span></td>
                            <td>{{ $student->date_of_birth->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" 
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
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-user-slash fa-3x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No students found</h5>
                                <a href="{{ route('students.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus me-2"></i>Add First Student
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($students->hasPages())
        <div class="card-footer bg-light">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</x-app-layout>



