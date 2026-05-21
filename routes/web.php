<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\InterviewController;


// ============================================================
// TEMPORARY ROUTE - HAPUS SETELAH DIGUNAKAN!
// Akses: /setup/reset-x9k2m7 untuk reset password wawancara
// ============================================================
Route::get('/setup/reset-x9k2m7', function () {
    $user = \App\Models\User::where('email', 'wawancara@gmail.com')->first();
    if (!$user) {
        return response('<h2 style="color:red">❌ User tidak ditemukan di database ini.</h2>', 404);
    }
    $user->update([
        'password'          => \Illuminate\Support\Facades\Hash::make('wawancara'),
        'email_verified_at' => $user->email_verified_at ?? now(),
        'role'              => 'interviewer',
    ]);
    $ok = \Illuminate\Support\Facades\Hash::check('wawancara', $user->fresh()->password);
    return response('
        <style>body{font-family:sans-serif;padding:40px;background:#f0fdf4;}</style>
        <h2 style="color:#15803d">✅ Reset Berhasil!</h2>
        <ul>
            <li><b>Email:</b> ' . $user->email . '</li>
            <li><b>Nama:</b> ' . $user->name . '</li>
            <li><b>Role:</b> ' . $user->role . '</li>
            <li><b>Email Verified:</b> ' . $user->fresh()->email_verified_at . '</li>
            <li><b>Hash Check:</b> ' . ($ok ? '✅ MATCH' : '❌ MISMATCH') . '</li>
        </ul>
        <p style="color:#6b7280;font-size:0.85rem">⚠️ Hapus route ini dari routes/web.php setelah selesai.</p>
        <a href="/login" style="background:#4f46e5;color:white;padding:10px 20px;border-radius:8px;text-decoration:none;">→ Ke Halaman Login</a>
    ');
});

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

// Protected Interview Log Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/interview/create', [InterviewController::class, 'create'])->name('interview.create');
    Route::post('/interview/store', [InterviewController::class, 'store']);
    Route::get('/interview/export', [InterviewController::class, 'exportExcel'])->name('interview.export');
});



