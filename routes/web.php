<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalysisController;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Kuesioner Routes (Respondents)
Route::middleware('auth')->group(function () {
    Route::get('/kuesioner', [KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::get('/kuesioner/create', [KuesionerController::class, 'create'])->name('kuesioner.create');
    Route::post('/kuesioner', [KuesionerController::class, 'store'])->name('kuesioner.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/show/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/analysis', [AnalysisController::class, 'index'])->name('admin.analysis');
    Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
