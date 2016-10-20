<?php
/**
 * Created by PhpStorm.
 * User: dmitry2
 * Date: 18.10.2016
 * Time: 18:20
 */

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use App\User;

class UserRepository
{

    public function checkMatchPassword($oldpassword)
    {
        return Hash::check($oldpassword, auth()->user()->getAuthPassword());
    }

    public function changePassword($oldpassword, $newpassword)
    {
        if ($oldpassword !== $newpassword) {
            $user = User::where('id',auth()->id())->first();
            $user->password = bcrypt($newpassword);
            $user->save();
            return "Password changed";
        } else {
            return "New and Old password is equils";
        }
    }

}