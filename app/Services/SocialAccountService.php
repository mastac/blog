<?php

namespace App\Services;

use App\User;
use App\SocialAccount;
use Carbon\Carbon;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{

    public function createOrGetUser(ProviderUser $provideruser)
    {
        $account = SocialAccount::whereProvider('vkontakte')
            ->whereProviderUserId($provideruser->getId())
            ->first();

        if($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $provideruser->getId(),
                'provider' => 'vkontakte'
            ]);

            $user = User::whereEmail($provideruser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $provideruser->getEmail(),
                    'name' => $provideruser->getNickname(),
                    'first_name' => $provideruser->getRaw()['first_name'],
                    'last_name' => $provideruser->getRaw()['last_name'],
                    'password' => str_random(16)
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }

}
