<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class verificationController extends Controller
{
    // Menampilkan notifikasi verifikasi
    public function notice()
    {
        return "mohon untuk melakukan verifikasi email terlebih dahulu";
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/user/dashboard')->with('msg', 'Email Anda telah berhasil diverifikasi.');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('msg', 'Email verifikasi telah dikirim ulang.');
    }
}
