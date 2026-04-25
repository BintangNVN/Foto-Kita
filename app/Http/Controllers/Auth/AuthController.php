<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'login',
                'description' => 'User login berhasil.',
                'ip_address'  => $request->ip(),
            ]);

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($user);

        ActivityLog::create([
            'user_id'     => $user->id,
            'action'      => 'register',
            'description' => 'User baru mendaftar.',
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'logout',
            'description' => 'User logout.',
            'ip_address'  => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
