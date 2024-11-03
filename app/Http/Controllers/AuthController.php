<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'email' => "required|email",
            'password' => "required",
        ]);

        // Try logging in as admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/admin/dashboard');
        }
        // Try logging in as regular user
        elseif (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/user/dashboard');
        }
        else {
            return redirect()->back()->with('msg', 'Email & password incorrect');
        }
    }

    public function logout()
    {
        // Logout from admin or user guard based on which one is logged in
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        return redirect(route('auth.index'));
    }
}
