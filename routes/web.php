<?php

use App\Models\Candidate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AdminController;

// Home route
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Voting routes
    Route::get('/vote', [VotingController::class, 'index'])->name('vote.index');
    Route::post('/vote', [VotingController::class, 'store'])->name('vote.store');
    
    // Results routes
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('/api/vote-results', [ResultController::class, 'getResults'])->name('results.data');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
    
    // Candidates Management
    Route::get('/candidates', [AdminController::class, 'candidates'])
        ->name('admin.candidates');
    Route::post('/candidates', [AdminController::class, 'store'])
        ->name('admin.candidates.store');
    Route::get('/candidates/{candidate}', [AdminController::class, 'show'])
        ->name('admin.candidates.show');
    Route::put('/candidates/{candidate}', [AdminController::class, 'update'])
        ->name('admin.candidates.update');
    Route::delete('/candidates/{candidate}', [AdminController::class, 'destroy'])
        ->name('admin.candidates.destroy');
});