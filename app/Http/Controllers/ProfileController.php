<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Requests;

use App\User;

class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    private $user;

    /**
     * ProfileController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = auth()->user();
        return view('profile.profile', compact('user'))->with('user', $user);
    }

    public function store()
    {
        return 'profile store';
    }

    public function changepassword()
    {
        return view('profile.changepassword');
    }

    public function storechangepassword(UserRepository $userRepository, Request $request)
    {

        $this->validate($request, [
            'oldpassword' => 'required',
            'newpassword' => 'required|min:6|confirmed',
        ]);

        // TODO: Имеет ли смысол создавать валидатор для проверки пароля?
        if ($userRepository->checkMatchPassword($request->input('oldpassword'))) {
            $message = $userRepository->changePassword($request->input('oldpassword'), $request->input('newpassword'));

            \Session::flash('flash_message_success',$message);
            $request->session()->flash('status', $message);
            return redirect('profile/changepassword');
        } else {

            \Session::flash('flash_message_error',"Incorrect old password");
            return redirect('profile/changepassword');
        }
    }

}
