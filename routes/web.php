<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminJobController;
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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeekerController;
use App\Models\Application;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Authentication routes
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'storeLogin'])->name('storeLogin');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'storeRegister'])->name('storeRegister');

// Public job routes
Route::get('jobs', [HomeController::class, 'indexJobs'])->name('home.jobs.index');
Route::get('jobs/{job}', [HomeController::class, 'showJob'])->name('jobs.show');
Route::get('jobs/browse', [HomeController::class, 'browseJobs'])->name('jobs.browse');


// Public company routes
Route::resource('companies', CompanyController::class);
Route::get('/companies/{company}/jobs', [CompanyController::class, 'jobs'])->name('company.jobs');

// Public category routes
Route::resource('categories', CategoryController::class);
Route::get('/categories/{category:slug}/jobs', [CategoryController::class, 'jobs'])->name('category.jobs');
Route::get('/categories/browse', [CategoryController::class, 'browse'])->name('categories.browse');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Authenticated routes
Route::group(['middleware' => ['auth']], function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resume routes
    Route::resource('resumes', ResumeController::class)->except(['index', 'create', 'store']);
    Route::get('get_states/{state}/edit', [ResumeController::class, 'getStates']);

    // Job CRUD routes
    Route::get('jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::post('jobs/{job}/save', [JobController::class, 'save'])->name('jobs.save');
    Route::get('jobs/created-Job', [JobController::class, 'created'])->name('jobs.createdJob');

    // Application routes
    Route::prefix('jobs/{job}')->group(function () {
        Route::get('/applicants', [ApplicationController::class, 'index'])->name('jobs.applicants');
        Route::get('/apply', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');
    });

    // Application management
    Route::prefix('applications')->group(function () {
        Route::resource('/', Application::class);
        Route::put('/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
        Route::delete('/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.myApplications');
    });

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');

        // User Management
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');

        // Application Management
        Route::get('/applications', [ApplicationController::class, 'adminApplicationIndex'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'adminApplicationShow'])->name('applications.show');
        Route::get('/applications/{application}/edit', [ApplicationController::class, 'adminApplicationEdit'])->name('applications.edit');
        Route::put('/applications/{application}/status', [ApplicationController::class, 'applicationUpdateStatus'])->name('applications.update-status');
        Route::delete('/applications/{application}', [AdminController::class, 'applicationsDestroy'])->name('applications.destroy');
        Route::get('/applications/{application}/download-application', [AdminController::class, 'applicationDownload'])->name('applications.download');

        // Settings & Reports
        Route::get('/settings', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/settings/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/settings', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/settings/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::get('/settings/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/settings/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/settings/{role}/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/reports', [RoleController::class, 'reports'])->name('roles.reports');

        //Add user role assignment route
        Route::get('/settings/users/assign-role', [RoleController::class, 'showAssignRoleForm'])->name('settings.users.show-assign-role');
        Route::post('/users/assign-role', [RoleController::class, 'assignRoleToUser'])->name('users.assign-role');
        Route::delete('/users/{user}/roles/{role}', [RoleController::class, 'removeRoleFromUser'])->name('users.remove-role');

        // Category Management
        Route::resource('categories', CategoryController::class);
        // Company Management
        // Route::resource('companies', CompanyController::class);
        Route::get('/companies', [CompanyController::class,'index'])->name('company.index');
        Route::get('/companies/create', [CompanyController::class,'create'])->name('company.create');
        Route::post('/companies', [CompanyController::class,'store'])->name('company.store');
        Route::get('/companies/{company}', [CompanyController::class,'show'])->name('company.show');
        Route::get('/companies/{company}/jobs', [CompanyController::class, 'jobs'])->name('company.jobs');
    });

    // Employer routes
    Route::prefix('employer')->name('employer')->middleware(['role:employer'])->group(function () {
        Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
        Route::get('/my-companies', [CompanyController::class, 'myCompanies'])->name('companies.my');
    });

    // Seeker routes
    Route::prefix('seeker')->name('seeker.')->middleware(['role:job-seeker'])->group(function () {
        Route::get('/seeker/dashboard', [SeekerController::class, 'dashboard'])->name('dashboard');
        // Route::get('/jobs', [SeekerController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/browse', [JobController::class, 'browse'])->name('jobs.browse');
        Route::get('/jobs/{job}', [SeekerController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/apply', [SeekerController::class, 'create'])->name('jobs.apply');
        Route::post('/jobs/{job}/apply', [SeekerController::class, 'store'])->name('application.save');
        Route::get('/jobs/{job}', [SeekerController::class, 'show'])->name('application.show');
        Route::get('/jobs/{job}/edit', [SeekerController::class, 'edit'])->name('application.edit');
        Route::put('/jobs/{job}', [SeekerController::class, 'update'])->name('application.update');
        Route::get('/applications', [SeekerController::class, 'applications'])->name('my-applications');


        // Seeker Resume Route
        Route::get('/resumes/create', [ResumeController::class, 'create'])->name('resumes.create');
        Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
        Route::get('/resumes/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
        Route::get('/resumes/{resume}/edit', [ResumeController::class, 'edit'])->name('resumes.edit');
        Route::put('/resumes', [ResumeController::class, 'update'])->name('resumes.update');
        Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
        Route::get('/resumes/{resume}/download/', [ResumeController::class, 'download'])->name('resumes.download');

        Route::get('/{resume}/download', [ResumeController::class, 'download'])->name('download');
        Route::get('/{resume}/preview', [ResumeController::class, 'preview'])->name('preview');
        Route::post('/{resume}/save-pdf', [ResumeController::class, 'savePdf'])->name('save-pdf');
    });
});

require __DIR__ . '/auth.php';
