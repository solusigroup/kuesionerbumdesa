<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\MagicLinkMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Informasi akun yang Anda masukkan tidak sesuai.',
            ])->onlyInput('email');
        }

        // If it's a superadmin, they must use a password
        if ($user->role === 'superadmin' || $request->has('password_mode')) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $request->session()->put('password_confirmed_at', now()->timestamp);
                
                if (Auth::user()->role === 'superadmin') {
                    return redirect()->route('admin.dashboard');
                }
                
                return redirect()->intended('/kuesioner/create');
            }

            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ])->onlyInput('email');
        }

        // For respondents, send magic link
        return $this->sendMagicLink($request);
    }

    public function sendMagicLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar. Silakan daftar terlebih dahulu.']);
        }

        $token = Str::random(64);
        $user->update([
            'login_token' => $token,
            'login_token_expires_at' => now()->addMinutes(30),
        ]);

        $url = route('login.verify', ['token' => $token]);
        Mail::to($user->email)->send(new MagicLinkMail($url));

        return back()->with('success', 'Link login telah dikirim ke email Anda. Silakan cek kotak masuk atau spam.');
    }

    public function verifyMagicLink($token)
    {
        $user = User::where('login_token', $token)
            ->where('login_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Link tidak valid atau sudah kedaluwarsa.');
        }

        $user->update([
            'login_token' => null,
            'login_token_expires_at' => null,
        ]);

        Auth::login($user);
        session()->regenerate();

        return redirect()->route('kuesioner.create');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => null, // No password initially
            'is_password_set' => false,
            'role' => 'respondent',
        ]);

        Auth::login($user);
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function showSetPassword()
    {
        return view('auth.set-password');
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
            'is_password_set' => true,
        ]);

        $request->session()->put('password_confirmed_at', now()->timestamp);

        return redirect()->route('kuesioner.index')->with('success', 'Password berhasil diatur.');
    }

    public function showConfirmPassword()
    {
        if (!Auth::user()->is_password_set) {
            return redirect()->route('password.set');
        }
        return view('auth.confirm-password');
    }

    public function confirmPassword(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if (Hash::check($request->password, Auth::user()->password)) {
            $request->session()->put('password_confirmed_at', now()->timestamp);
            return redirect()->route('kuesioner.index');
        }

        return back()->withErrors(['password' => 'Password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
