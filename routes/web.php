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

// Handle default redirect for authenticated users hitting guest routes
Route::get('/home', function () {
    if (auth()->check() && auth()->user()->role === 'superadmin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('kuesioner.create');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/magic', [AuthController::class, 'sendMagicLink'])->name('login.magic');
    Route::get('/login/verify/{token}', [AuthController::class, 'verifyMagicLink'])->name('login.verify');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('kuesioner.create');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Protected Kuesioner Routes (Respondents)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kuesioner', [KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::get('/kuesioner/thanks', [KuesionerController::class, 'thanks'])->name('kuesioner.thanks');
    Route::get('/kuesioner/create', [KuesionerController::class, 'create'])->name('kuesioner.create');
    Route::post('/kuesioner', [KuesionerController::class, 'store'])->name('kuesioner.store');
    
    // Password setting for results
    Route::get('/kuesioner/set-password', [AuthController::class, 'showSetPassword'])->name('password.set');
    Route::post('/kuesioner/set-password', [AuthController::class, 'setPassword'])->name('password.update');
    Route::get('/kuesioner/confirm-password', [AuthController::class, 'showConfirmPassword'])->name('password.confirm_view');
    Route::post('/kuesioner/confirm-password', [AuthController::class, 'confirmPassword'])->name('password.confirm_action');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/show/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/whatsapp', [AdminController::class, 'whatsapp'])->name('admin.whatsapp');
    Route::get('/lottery', [AdminController::class, 'lottery'])->name('admin.lottery');
    Route::post('/lottery/draw', [AdminController::class, 'performLottery'])->name('admin.lottery.draw');
    Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::get('/analysis', [AnalysisController::class, 'index'])->name('admin.analysis');
