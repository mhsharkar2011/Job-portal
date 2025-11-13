<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SeekerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'storeLogin'])->name('storeLogin');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'storeRegister'])->name('storeRegister');

// Admin routes
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::prefix('admin')->name('admin.')->group(function(){
        // Route::resource('users', AdminController::class);

        // User Management
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');

    });
});


Route::prefix('auth')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');
    // Category Routes
    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{category:slug}/jobs', [CategoryController::class, 'jobs'])->name('category.jobs');
    Route::get('/categories/browse', [CategoryController::class, 'browse'])->name('categories.browse');
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');


    // Employer routes
    Route::middleware(['auth', 'role:employer'])->group(function () {
        Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
        Route::resource('jobs', JobController::class);
        Route::get('/jobs/{job}/applicants', [JobController::class, 'applicants'])->name('jobs.applicants');
    });

    // Seeker routes
    Route::middleware(['auth', 'role:seeker'])->group(function () {
        Route::get('/seeker/dashboard', [SeekerController::class, 'dashboard'])->name('seeker.dashboard');
        Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');
    });



    // Company Routes
    Route::resource('companies', CompanyController::class);
    Route::get('/my-companies', [CompanyController::class, 'myCompanies'])->name('companies.my');
    Route::get('/companies/{company}/jobs', [CompanyController::class, 'jobs'])->name('company.jobs');

    // Job Routes
    Route::resource('jobs', JobController::class);
});




Route::group(['middleware' => ['auth']], function () {

    // Route::prefix('admins')->group(function () {

    // });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {



        // User Management
        // Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
        // Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
        // Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
        // Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
        // Route::delete('/users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');

        // Job Management

        Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs.index');
        Route::get('/jobs/create', [AdminController::class, 'create'])->name('admin.jobs.create');
        Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs.index');
        Route::get('/jobs/{job}', [AdminController::class, 'jobShow'])->name('jobs.show');
        Route::get('/jobs/{job}/edit', [AdminController::class, 'jobEdit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [AdminController::class, 'jobUpdate'])->name('jobs.update');
        Route::delete('/jobs/{job}', [AdminController::class, 'jobDestroy'])->name('jobs.destroy');

        // Application Management
        Route::get('/applications', [AdminController::class, 'applications'])->name('applications.index');
        Route::get('/applications/{application}', [AdminController::class, 'applicationShow'])->name('applications.show');
        Route::put('/applications/{application}/status', [AdminController::class, 'applicationUpdateStatus'])->name('applications.update-status');

        // Settings & Reports
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });



    Route::prefix('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Resume APIs
        Route::resource('resumes', ResumeController::class)->except(['index', 'create', 'store']);
        Route::get('get_states/{state}/edit', [ResumeController::class, 'getStates']);



        // Use this instead - it already exists in your AdminController

        // Route::get('/admins/users', [AdminController::class, 'adminDashboardCreate'])->name('admin.users.create');
        Route::get('admin/users/{user}', [AdminController::class, 'adminUserShow'])->name('admin.users.show');
        Route::get('/admins/users/{user}/edit', [AdminController::class, 'adminUserEdit'])->name('admin.users.edit');
        Route::put('users/{user}', [AdminController::class, 'adminUserUpdate'])->name('admin.users.update');
        Route::get('/admins/users/{user}', [AdminController::class, 'adminUserDestroy'])->name('admin.users.destroy');
        Route::get('/admins/applications', [AdminController::class, 'applications'])->name('admin.applications.index');
        Route::put('/applications/{application}/status', [AdminController::class, 'applicationUpdateStatus'])->name('applications.update-status');
        Route::get('/admins/applications/{application}', [AdminController::class, 'applicationsDestroy'])->name('admin.applications.destroy');
        Route::get('/admins/applications', [AdminController::class, 'applicationsDownload'])->name('admin.applications.download-resume');
        Route::get('/admins/jobs', [AdminController::class, 'adminDashboardJobs'])->name('admin.jobs.index');
        Route::post('/admins/jobs/create', [AdminController::class, 'adminDashboardJobsCreate'])->name('admin.jobs.create');
        Route::get('/admins/setting', [AdminController::class, 'adminDashboardSettings '])->name('admin.settings');


        // Jobs Route
        Route::get('jobs', [JobController::class, 'index'])->name('jobs.appliedJob');
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


// Public routes
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
Route::get('browse', [JobController::class, 'browse'])->name('jobs.browse');
Route::resource('companies', CompanyController::class);
Route::get('/companies/{company}/jobs', [CompanyController::class, 'jobs'])->name('company.jobs');
Route::resource('categories', CategoryController::class);
Route::get('/categories/{category:slug}/jobs', [CategoryController::class, 'jobs'])->name('category.jobs');
Route::get('/categories/browse', [CategoryController::class, 'browse'])->name('categories.browse');
