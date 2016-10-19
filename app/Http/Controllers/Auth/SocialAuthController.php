<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialAccountService;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::with('vkontakte')->redirect();
    }

    public function callback(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('vkontakte')->user());
        auth()->login($user);

        return redirect()->to('/home');
    }
}
