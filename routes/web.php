<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\HeadmasterController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::get('/setup', function () {
    \Artisan::call('migrate --force');
    \Artisan::call('db:seed --force');
    return 'Database setup completed! Users and tables created.';
});
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Students Management
    Route::resource('students', StudentController::class);

    // Subjects Management
    Route::resource('subjects', SubjectController::class);

    // Results Management
    Route::resource('results', ResultController::class);
    Route::get('results/bulk/upload', [ResultController::class, 'bulkUpload'])->name('results.bulk');
    Route::post('results/bulk/store', [ResultController::class, 'storeBulk'])->name('results.bulk.store');

    // Attendance Management
    Route::resource('attendance', AttendanceController::class);

    // Headmaster Routes (Only accessible by headmaster)
    Route::prefix('headmaster')->name('headmaster.')->group(function () {
        Route::get('pending-results', [HeadmasterController::class, 'pendingResults'])->name('pending-results');
        Route::post('results/{result}/release', [HeadmasterController::class, 'releaseResult'])->name('release-result');
        Route::post('results/{result}/lock', [HeadmasterController::class, 'lockResult'])->name('lock-result');
        Route::post('results/{result}/unlock', [HeadmasterController::class, 'unlockResult'])->name('unlock-result');
        
        Route::get('term-results', [HeadmasterController::class, 'termResults'])->name('term-results');
        Route::post('compile-term-result', [HeadmasterController::class, 'compileTermResult'])->name('compile-term-result');
        Route::post('term-results/{termResult}/approve', [HeadmasterController::class, 'approveTermResult'])->name('approve-term-result');
        Route::post('term-results/{termResult}/remark', [HeadmasterController::class, 'addHeadmasterRemark'])->name('add-remark');
        Route::post('term-results/{termResult}/backup', [HeadmasterController::class, 'backupToGoogleDrive'])->name('backup');
        Route::get('term-results/{termResult}/print', [HeadmasterController::class, 'printResult'])->name('print-result');
    });
});