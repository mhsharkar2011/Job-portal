<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $data['jobs'] = Job::all();
    return view('welcome', $data);
});


// In routes/web.php
Route::get('/', function () {
    $jobs = \App\Models\Job::withCount('applications')
                          ->latest()
                          ->take(9)
                          ->get();
    return view('welcome', compact('jobs'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'storeLogin'])->name('storeLogin');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'storeRegister'])->name('storeRegister');

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Resume APIs
        Route::resource('resumes', ResumeController::class)->except(['index', 'create', 'store']);
        Route::get('get_states/{state}/edit', [ResumeController::class, 'getStates']);
        // Jobs APIs
        Route::get('jobs', [JobController::class, 'index'])->name('jobs.appliedJob');
        // Create Jobs
        Route::Post('jobs', [JobController::class, 'store'])->name('jobs.postJob');
        Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::get('jobs/created-Job', [JobController::class, 'created'])->name('jobs.createdJob');
        Route::put('jobs', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        // User APIs
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Job CRUD
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::post('/jobs/{job}/save', [JobController::class, 'save'])->name('jobs.save');
     Route::get('/jobs/browse', [JobController::class, 'browse'])->name('jobs.browse');


    // Application Routes
    Route::prefix('jobs/{job}')->group(function () {
        // Show applicants for a job
        Route::get('/applicants', [ApplicationController::class, 'index'])->name('jobs.applicants');

        // Create application
        Route::get('/apply', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');
    });


    // Application management
    Route::prefix('applications')->group(function () {
        Route::put('/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
        Route::delete('/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.myApplications');
    });
});

require __DIR__ . '/auth.php';


// Public job viewing (if needed)
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
