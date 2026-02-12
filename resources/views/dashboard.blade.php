<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Stats Grid -->
    <div class="row mb-4">
        <!-- Total Students -->
        <div class="col-md-3">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Students</p>
                            <h2 class="mb-0">{{ $stats['total_students'] }}</h2>
                        </div>
                        <div class="bg-primary text-white rounded p-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Subjects -->
        <div class="col-md-3">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Subjects</p>
                            <h2 class="mb-0">{{ $stats['total_subjects'] }}</h2>
                        </div>
                        <div class="bg-success text-white rounded p-3">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Results -->
        <div class="col-md-3">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Results</p>
                            <h2 class="mb-0">{{ $stats['total_results'] }}</h2>
                        </div>
                        <div class="bg-warning text-white rounded p-3">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <!-- Pending Approvals -->
        <div class="col-md-3">
            <div class="card border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending Approvals</p>
                            <h2 class="mb-0">{{ $stats['pending_approvals'] }}</h2>
                        </div>
                        <div class="bg-danger text-white rounded p-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('students.create') }}" class="text-decoration-none">
                        <div class="card bg-primary bg-opacity-10 border-primary h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-user-plus fa-2x text-primary me-3"></i>
                                <span class="fw-bold text-dark">Add New Student</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('subjects.create') }}" class="text-decoration-none">
                        <div class="card bg-success bg-opacity-10 border-success h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-plus fa-2x text-success me-3"></i>
                                <span class="fw-bold text-dark">Add New Subject</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('results.create') }}" class="text-decoration-none">
                        <div class="card bg-warning bg-opacity-10 border-warning h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x text-warning me-3"></i>
                                <span class="fw-bold text-dark">Enter Result</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>