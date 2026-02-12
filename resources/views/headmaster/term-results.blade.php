<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-graduation-cap me-2"></i>Term Results Management
    </x-slot>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0 text-white"><i class="fas fa-plus-circle me-2"></i>Compile Term Result</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('headmaster.compile-term-result') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Student</label>
                                <select name="student_id" class="form-select" required>
                                    <option value="">Select Student</option>
                                    @foreach(\App\Models\Student::all() as $student)
                                        <option value="{{ $student->id }}">{{ $student->admission_number }} - {{ $student->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Term</label>
                                <select name="term" class="form-select" required>
                                    <option value="">Select Term</option>
                                    <option value="First Term">First Term</option>
                                    <option value="Second Term">Second Term</option>
                                    <option value="Third Term">Third Term</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Session</label>
                                <input type="text" name="session" class="form-control" placeholder="e.g., 2023/2024" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cogs me-2"></i>Compile Result
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Results</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('headmaster.term-results') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Term</label>
                        <select name="term" class="form-select">
                            <option value="">All Terms</option>
                            <option value="First Term" {{ request('term') == 'First Term' ? 'selected' : '' }}>First Term</option>
                            <option value="Second Term" {{ request('term') == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                            <option value="Third Term" {{ request('term') == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Session</label>
                        <input type="text" name="session" class="form-control" value="{{ request('session') }}" placeholder="e.g., 2023/2024">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="fas fa-search me-2"></i>Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-table me-2"></i>Compiled Term Results</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Term/Session</th>
                            <th class="text-center">Average</th>
                            <th class="text-center">GPA</th>
                            <th class="text-center">Position</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($termResults as $termResult)
                        <tr>
                            <td class="fw-bold">
                                {{ $termResult->student->full_name }}
                                <br>
                                <small class="text-muted">{{ $termResult->student->admission_number }}</small>
                            </td>
                            <td>{{ $termResult->student->class }}</td>
                            <td>
                                <span class="badge bg-info">{{ $termResult->term }}</span>
                                <br>
                                <small>{{ $termResult->session }}</small>
                            </td>
                            <td class="text-center">
                                <strong class="text-primary">{{ number_format($termResult->average_score, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ number_format($termResult->gpa, 2) }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">
                                    @if($termResult->position)
                                        {{ $termResult->position }}{{ $termResult->position == 1 ? 'st' : ($termResult->position == 2 ? 'nd' : ($termResult->position == 3 ? 'rd' : 'th')) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">
                                @if($termResult->is_approved)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Approved
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('headmaster.print-result', $termResult) }}" class="btn btn-info" title="Print">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if(!$termResult->is_approved)
                                    <form action="{{ route('headmaster.approve-term-result', $termResult) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Approve this result?')" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @if(!$termResult->is_backed_up)
                                    <form action="{{ route('headmaster.backup', $termResult) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" title="Backup">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-secondary" disabled title="Already backed up">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                    @endif
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#remarkModal{{ $termResult->id }}" title="Add Remark">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                </div>

                                <!-- Remark Modal -->
                                <div class="modal fade" id="remarkModal{{ $termResult->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Headmaster's Remark</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('headmaster.add-remark', $termResult) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Remark:</label>
                                                        <p class="text-muted">{{ $termResult->headmaster_remark ?? 'No remark yet' }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">New Remark</label>
                                                        <textarea name="headmaster_remark" class="form-control" rows="4" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Remark</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No term results found</h5>
                                <p class="text-muted">Compile a term result to get started!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($termResults->hasPages())
        <div class="card-footer bg-light">
            {{ $termResults->links() }}
        </div>
        @endif
    </div>
</x-app-layout>