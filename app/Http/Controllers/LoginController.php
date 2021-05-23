<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage()
    {
        return view('login');
    }
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            return redirect('user');
        }
        return redirect('/login')
            ->withErrors('Email and password are invalid!')
            ->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
