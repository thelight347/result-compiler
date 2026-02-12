{{-- resources/views/subjects/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-book me-2"></i>Subjects Management
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient d-flex justify-content-between align-items-center" 
             style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-book-open me-2"></i>All Subjects</h5>
            <a href="{{ route('subjects.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-2"></i>Add New Subject
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Class</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                        <tr>
                            <td><span class="badge bg-primary">{{ $subject->code }}</span></td>
                            <td class="fw-bold">{{ $subject->name }}</td>
                            <td><span class="badge bg-success">{{ $subject->class }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline" 
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
                            <td colspan="4" class="text-center py-5">
                                <i class="fas fa-book-dead fa-3x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No subjects found</h5>
                                <a href="{{ route('subjects.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus me-2"></i>Add First Subject
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($subjects->hasPages())
        <div class="card-footer bg-light">
            {{ $subjects->links() }}
        </div>
        @endif
    </div>
</x-app-layout>