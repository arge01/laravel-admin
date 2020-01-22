<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Uyeler;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function oturumac()
    {
        Auth::guard('yonetim')->logout();
        if (request()->isMethod('POST')) {
            $this->validate(request(), ['email' => 'required|email', 'sifre' => 'required']);
            $giris = ['email' => request('email'), 'password' => request('sifre'), 'rutbeler' => 1];
            if (Auth::guard('yonetim')->attempt($giris, request()->has('benihatirla'))) {
                return redirect()->route('yonetim.anasayfa');
            } else {
                return back()->withInput()->withErrors(['email' => 'Kullanıcı adı hatalı']);
            }
        } else {
            return view('yonetim.giris');
        }
    }

    public function oturumkapat()
    {
        Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }
}