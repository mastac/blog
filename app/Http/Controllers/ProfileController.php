<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use App\User;

class ProfileController extends Controller
{

    /**
     * ProfileController constructor.
     * @param UserRepository $user
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Guard $auth, Request $request)
    {
        return view('profile.profile')->with('user', $auth->user())->with('request', $request);
    }

    public function store(Guard $auth, Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $auth->user()->name = $request->input('name');
        $auth->user()->first_name = $request->input('first_name');
        $auth->user()->last_name = $request->input('last_name');

        $auth->user()->save();

        return redirect('profile');
    }

    public function changepassword(Request $request)
    {
        return view('profile.changepassword')->with('active', 'changepassword')->with('request', request());
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
