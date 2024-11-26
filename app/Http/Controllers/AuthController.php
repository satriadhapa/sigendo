<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user and trigger email verification
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user)); // Trigger the email verification event
        auth()->login($user);

        return redirect()->route('verification.notice')->with('msg', 'Akun berhasil dibuat. Silakan cek email Anda untuk verifikasi.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => "required|email",
            'password' => "required",
        ]);

        // Attempt to log in as admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/admin/dashboard');
        }
        // Attempt to log in as regular user
        elseif (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (!Auth::guard('user')->user()->hasVerifiedEmail()) {
                Auth::guard('user')->logout();
                return redirect()->back()->with('msg', 'Silakan verifikasi email Anda terlebih dahulu.');
            }
            return redirect()->intended('/user/dashboard');
        } else {
            return redirect()->back()->with('msg', 'Email & password tidak sesuai.');
        }
    }

    public function logout(Request $request)
    {
        // Logout from admin or user guard
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }

        // Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('auth.index'));
    }
}
