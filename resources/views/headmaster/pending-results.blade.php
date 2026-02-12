<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-clock me-2"></i>Pending Results
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-hourglass-half me-2"></i>Pending Results for Approval</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>Term/Session</th>
                            <th class="text-center">CA Total</th>
                            <th class="text-center">Exam</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Grade</th>
                            <th>Teacher</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                        <tr>
                            <td class="fw-bold">{{ $result->student->full_name }}</td>
                            <td>{{ $result->subject->name }}</td>
                            <td><small>{{ $result->term }} / {{ $result->session }}</small></td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $result->ca1_score + $result->ca2_score + $result->ca3_score }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">{{ $result->exam_score }}</span>
                            </td>
                            <td class="text-center">
                                <strong class="text-primary">{{ $result->total_score }}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $result->grade == 'A+' || $result->grade == 'A' ? 'success' : ($result->grade == 'F' ? 'danger' : 'warning') }}">
                                    {{ $result->grade }}
                                </span>
                            </td>
                            <td>{{ $result->teacher->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('headmaster.release-result', $result) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Release this result?')">
                                        <i class="fas fa-check me-1"></i>Release
                                    </button>
                                </form>
                                @if(!$result->is_locked)
                                <form action="{{ route('headmaster.lock-result', $result) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-dark" onclick="return confirm('Lock this result?')">
                                        <i class="fas fa-lock me-1"></i>Lock
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                                <h5 class="text-muted">No pending results</h5>
                                <p class="text-muted">All results have been released!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($results->hasPages())
        <div class="card-footer bg-light">
            {{ $results->links() }}
        </div>
        @endif
    </div>
</x-app-layout>