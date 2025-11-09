<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'storeLogin')->name('storeLogin');
    Route::get('register', 'register')->name('register');
    Route::post('register', 'storeRegister')->name('storeRegister');
});

// Public Job Routes
Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index')->name('jobs.index');
    Route::get('/jobs/{job}', 'show')->name('jobs.show');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Authentication
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Resume Routes
    Route::resource('resumes', ResumeController::class)->except(['index', 'create', 'store']);
    Route::get('get_states/{state}/edit', [ResumeController::class, 'getStates']);

    // Category Routes
    Route::controller(CategoryController::class)->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::get('/categories/{category:slug}/jobs', 'jobs')->name('category.jobs');
        Route::get('/categories/browse', 'browse')->name('categories.browse');
        Route::get('/categories/{category:slug}', 'show')->name('categories.show');
    });

    // Company Routes
    Route::controller(CompanyController::class)->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::get('/my-companies', 'myCompanies')->name('companies.my');
        Route::get('/companies/{company}/jobs', 'jobs')->name('company.jobs');
    });

    // Job Management Routes
    Route::controller(JobController::class)->group(function () {
        Route::get('/jobs/create', 'create')->name('jobs.create');
        Route::post('/jobs', 'store')->name('jobs.store');
        Route::get('/jobs/{job}/edit', 'edit')->name('jobs.edit');
        Route::put('/jobs/{job}', 'update')->name('jobs.update');
        Route::delete('/jobs/{job}', 'destroy')->name('jobs.destroy');
        Route::post('/jobs/{job}/save', 'save')->name('jobs.save');
        Route::get('/jobs/browse', 'browse')->name('jobs.browse');
        Route::get('jobs/created-Job', 'created')->name('jobs.createdJob');
    });

    // Application Routes
    Route::prefix('jobs/{job}')->group(function () {
        Route::controller(ApplicationController::class)->group(function () {
            Route::get('/applicants', 'index')->name('jobs.applicants');
            Route::get('/apply', 'create')->name('applications.create');
            Route::post('/apply', 'store')->name('applications.store');
        });
    });

    // Application Management
    Route::controller(ApplicationController::class)->group(function () {
        Route::put('/applications/{application}/status', 'updateStatus')->name('applications.updateStatus');
        Route::delete('/applications/{application}', 'destroy')->name('applications.destroy');
        Route::get('/my-applications', 'myApplications')->name('applications.myApplications');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::controller(AdminController::class)->group(function () {

            // Dashboard
            Route::get('/dashboard', 'dashboard')->name('dashboard');

            // User Management
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', 'users')->name('index');
                Route::get('/{user}', 'userShow')->name('show');
                Route::get('/{user}/edit', 'userEdit')->name('edit');
                Route::put('/{user}', 'userUpdate')->name('update');
                Route::delete('/{user}', 'userDestroy')->name('destroy');
            });

            // Job Management
            Route::prefix('jobs')->name('jobs.')->group(function () {
                Route::get('/', 'jobs')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/{job}', 'jobShow')->name('show');
                Route::get('/{job}/edit', 'jobEdit')->name('edit');
                Route::put('/{job}', 'jobUpdate')->name('update');
                Route::delete('/{job}', 'jobDestroy')->name('destroy');
            });

            // Application Management
            Route::prefix('applications')->name('applications.')->group(function () {
                Route::get('/', 'applications')->name('index');
                Route::get('/{application}', 'applicationShow')->name('show');
                Route::put('/{application}/status', 'applicationUpdateStatus')->name('update-status');
            });

            // Settings & Reports
            Route::get('/settings', 'settings')->name('settings');
            Route::put('/settings', 'updateSettings')->name('settings.update');
            Route::get('/reports', 'reports')->name('reports');
        });
    });
});

require __DIR__ . '/auth.php';
