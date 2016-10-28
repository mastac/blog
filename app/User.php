<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relation user and post as HasMany
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getPostsByUsername($username)
    {
        $user = $this->whereName($username)->firstOrFail();
        return $user->posts();
    }

    public static function changePassword($oldpassword, $newpassword)
    {
        if ($oldpassword !== $newpassword) {
            $user = User::where('id',auth()->id())->first();
            $user->password = bcrypt($newpassword);
            $user->save();
            return true;
        } else {
            return false;
        }
    }

    public static function checkMatchPassword($oldpassword)
    {
        return Hash::check($oldpassword, auth()->user()->getAuthPassword());
    }
}
