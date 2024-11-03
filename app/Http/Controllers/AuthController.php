<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'email' => "required|email",
            'password' => "required",
        ]);
        if(Auth::guard('admin')->attempt(['email' =>$request->email, 'password' =>$request->password, 'role'=> 'admin'])){
            return redirect()->intended('/dashboard');
        }
        else if(Auth::guard('user')->attempt(['email' =>$request->email, 'password' =>$request->password])){
            return redirect()->intended('/dashboard');
        }
        else{
            return redirect('/')->with('msg', 'Email & password salah');
        }
    }
    public function logout(){

    }
}
