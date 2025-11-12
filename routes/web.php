<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobStatusController;
use App\Http\Controllers\UploadImageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/debug', function () {
    return [
        'isSecure' => request()->isSecure(),
        'scheme' => request()->getScheme(),
        'url' => url('/test'),
        'x-forwarded-proto' => request()->header('X-Forwarded-Proto'),
    ];
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/image_list', [DashboardController::class, 'showImages'])->name('image_list');
    Route::get('/logs', [DashboardController::class, 'showLogs'])->name('logs');
    
    Route::get('/jobs', [JobStatusController::class, 'index'])->name('job_status');
    Route::get('/jobs/stats', [JobStatusController::class, 'stats'])->name('job_stats');
    Route::post('/jobs/dispatch', [JobStatusController::class, 'dispatch'])->name('job_dispatch');

    Route::resource('images', UploadImageController::class);
});
