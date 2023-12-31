<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $data['jobs'] = Job::all();
    return view('welcome',$data);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'storeLogin'])->name('storeLogin');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'storeRegister'])->name('storeRegister');

Route::group(['middleware' => ['auth']], function() {
    Route::prefix('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
        // Resume APIs
        Route::resource('resumes', ResumeController::class)->except(['index','create','store']);
        Route::get('get_states/{state}/edit',[ResumeController::class,'getStates']);
        // Jobs APIs
        Route::get('jobs', [JobController::class, 'index'])->name('jobs.appliedJob');
        Route::Post('jobs', [JobController::class, 'store'])->name('jobs.postJob');
        Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::get('jobs/createdJob', [JobController::class, 'created'])->name('jobs.createdJob');
        Route::put('jobs', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        // User APIs
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

require __DIR__ . '/auth.php';


Route::get('foo',function(){
    return "Hello";
});