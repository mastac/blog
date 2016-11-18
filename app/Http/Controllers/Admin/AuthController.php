<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $guard = 'admin';

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
//
//    protected function guard()
//    {
//        return \Auth::guard('admin');
//    }
}