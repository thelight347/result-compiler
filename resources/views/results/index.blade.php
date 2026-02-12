{{-- resources/views/results/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <i class="fas fa-file-alt me-2"></i>Results Management
    </x-slot>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Results</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('results.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Term</label>
                        <select name="term" class="form-select">
                            <option value="">All Terms</option>
                            <option value="First Term" {{ request('term') == 'First Term' ? 'selected' : '' }}>First Term</option>
                            <option value="Second Term" {{ request('term') == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                            <option value="Third Term" {{ request('term') == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Session</label>
                        <input type="text" name="session" class="form-control" value="{{ request('session') }}" placeholder="e.g., 2023/2024">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Class</label>
                        <input type="text" name="class" class="form-control" value="{{ request('class') }}" placeholder="e.g., JSS 1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-gradient d-flex justify-content-between align-items-center" 
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0 text-white"><i class="fas fa-list me-2"></i>All Results</h5>
            <div>
                <a href="{{ route('results.bulk') }}" class="btn btn-light btn-sm me-2">
                    <i class="fas fa-upload me-2"></i>Bulk Upload
                </a>
                <a href="{{ route('results.create') }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-plus me-2"></i>Add Result
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if($results->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No results found</h5>
                    <a href="{{ route('results.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add First Result
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px;"></th>
                                <th>Student</th>
                                <th>Admission No.</th>
                                <th>Class</th>
                                <th>Term/Session</th>
                                <th class="text-center">Subjects</th>
                                <th class="text-center">Average</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Group results by student, term, and session
                                $groupedResults = $results->groupBy(function($result) {
                                    return $result->student_id . '_' . $result->term . '_' . $result->session;
                                });
                                $rowIndex = 0;
                            @endphp

                            @foreach($groupedResults as $key => $studentResults)
                                @php
                                    $firstResult = $studentResults->first();
                                    $student = $firstResult->student;
                                    $totalScore = $studentResults->sum('total_score');
                                    $average = $studentResults->avg('total_score');
                                    $allReleased = $studentResults->every(fn($r) => $r->is_released);
                                    $anyLocked = $studentResults->contains(fn($r) => $r->is_locked);
                                    
                                    // Create a valid ID using only the row index
                                    $collapseId = 'collapse-' . $rowIndex;
                                    $iconId = 'icon-' . $rowIndex;
                                    $rowIndex++;
                                @endphp
                                
                                <!-- Main Student Row -->
                                <tr class="student-row" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" style="cursor: pointer;">
                                    <td class="text-center">
                                        <i class="fas fa-chevron-right toggle-icon" id="{{ $iconId }}"></i>
                                    </td>
                                    <td class="fw-bold">{{ $student->full_name }}</td>
                                    <td>{{ $student->admission_number }}</td>
                                    <td>{{ $student->class }}</td>
                                    <td><small>{{ $firstResult->term }} / {{ $firstResult->session }}</small></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $studentResults->count() }} Subject{{ $studentResults->count() > 1 ? 's' : '' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-success">{{ number_format($average, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        @if($anyLocked)
                                            <span class="badge bg-dark">
                                                <i class="fas fa-lock me-1"></i>Locked
                                            </span>
                                        @elseif($allReleased)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Released
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Collapsible Subject Details -->
                                <tr class="collapse" id="{{ $collapseId }}">
                                    <td colspan="8" class="p-0">
                                        <div class="bg-light p-3">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-book me-2"></i>Subject Breakdown for {{ $student->full_name }}
                                            </h6>
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>Subject</th>
                                                        <th class="text-center">1st CA</th>
                                                        <th class="text-center">2nd CA</th>
                                                        <th class="text-center">3rd CA</th>
                                                        <th class="text-center">CA Total</th>
                                                        <th class="text-center">Exam</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center">Grade</th>
                                                        <th class="text-center">Remark</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($studentResults as $result)
                                                    <tr>
                                                        <td class="fw-bold">{{ $result->subject->name }}</td>
                                                        <td class="text-center">
                                                            <span class="badge bg-primary">{{ $result->ca1_score }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-success">{{ $result->ca2_score }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-info">{{ $result->ca3_score }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-secondary">{{ $result->ca1_score + $result->ca2_score + $result->ca3_score }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-warning text-dark">{{ $result->exam_score }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <strong class="text-primary fs-6">{{ $result->total_score }}</strong>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-{{ $result->grade == 'A+' || $result->grade == 'A' ? 'success' : ($result->grade == 'F' ? 'danger' : 'warning') }}">
                                                                {{ $result->grade }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <small class="text-muted">{{ $result->remark }}</small>
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!$result->is_locked && !($result->is_released && auth()->user()->isTeacher()))
                                                            <a href="{{ route('results.edit', $result) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            @endif
                                                            @if(!$result->is_locked && auth()->user()->isHeadmaster())
                                                            <form action="{{ route('results.destroy', $result) }}" method="POST" class="d-inline" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this result?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-light">
                                                    <tr>
                                                        <th colspan="6" class="text-end">Total Score:</th>
                                                        <th class="text-center text-primary">{{ $totalScore }}</th>
                                                        <th colspan="3" class="text-end">
                                                            Average: <span class="text-success fw-bold">{{ number_format($average, 2) }}</span>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @if($results->hasPages())
        <div class="card-footer bg-light">
            {{ $results->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

<script>
    // Toggle chevron icon on collapse
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(element) {
            element.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target').replace('#', '');
                const iconId = targetId.replace('collapse-', 'icon-');
                const icon = document.getElementById(iconId);
                
                if (icon) {
                    // Toggle icon rotation
                    setTimeout(function() {
                        if (icon.classList.contains('fa-chevron-right')) {
                            icon.classList.remove('fa-chevron-right');
                            icon.classList.add('fa-chevron-down');
                        } else {
                            icon.classList.remove('fa-chevron-down');
                            icon.classList.add('fa-chevron-right');
                        }
                    }, 10);
                }
            });
        });
    });
</script>

<style>
.student-row {
    transition: background-color 0.2s ease;
}

.student-row:hover {
    background-color: rgba(102, 126, 234, 0.1);
}

.toggle-icon {
    transition: transform 0.3s ease;
    color: #667eea;
}

thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table-sm th, .table-sm td {
    padding: 0.5rem;
}

.collapse {
    transition: all 0.3s ease;
}

/* Add smooth animation for collapse */
.collapsing {
    transition: height 0.35s ease;
}

/* Highlight collapsed row */
tr.collapse.show {
    display: table-row;
}
</style>