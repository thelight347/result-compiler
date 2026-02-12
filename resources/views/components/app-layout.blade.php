<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Result Compiler') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #34495e;
            color: #fff;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar px-0">
                <div class="p-3 text-white">
                    <h4 class="mb-0">Result Compiler</h4>
                    <small>{{ auth()->user()->role }}</small>
                </div>
                <nav class="nav flex-column px-3">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                        <i class="fas fa-users me-2"></i> Students
                    </a>
                    <a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">
                        <i class="fas fa-book me-2"></i> Subjects
                    </a>
                    <a class="nav-link {{ request()->routeIs('results.*') ? 'active' : '' }}" href="{{ route('results.index') }}">
                        <i class="fas fa-file-alt me-2"></i> Results
                    </a>
                    <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                        <i class="fas fa-calendar-check me-2"></i> Attendance
                    </a>
                    
                    @if(auth()->user()->isHeadmaster())
                    <hr class="bg-light">
                    <small class="text-muted px-3">HEADMASTER AREA</small>
                    <a class="nav-link {{ request()->routeIs('headmaster.pending-results') ? 'active' : '' }}" href="{{ route('headmaster.pending-results') }}">
                        <i class="fas fa-clock me-2"></i> Pending Results
                    </a>
                    <a class="nav-link {{ request()->routeIs('headmaster.term-results') ? 'active' : '' }}" href="{{ route('headmaster.term-results') }}">
                        <i class="fas fa-graduation-cap me-2"></i> Term Results
                    </a>
                    @endif
                </nav>
                
                <div class="p-3 mt-auto" style="position: absolute; bottom: 0; width: 100%;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Header -->
                @if(isset($header))
                    <nav class="navbar navbar-light bg-light mb-4 rounded">
                        <div class="container-fluid">
                            <span class="navbar-brand mb-0 h1">{{ $header }}</span>
                            <span class="text-muted">
                                <i class="fas fa-user me-2"></i>{{ auth()->user()->name }}
                            </span>
                        </div>
                    </nav>
                @endif

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Slot -->
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>