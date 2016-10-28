<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use App\User;

class ProfileController extends Controller
{

    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Guard $auth, Request $request)
    {
        return view('profile.profile')
            ->with('page_title', 'Profile')
            ->with('user', $auth->user())
            ->with('request', $request);
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
        return view('profile.changepassword')
            ->with('page_title', 'Change password')
            ->with('active', 'changepassword')
            ->with('request', request());
    }

    public function storechangepassword(Request $request)
    {

        $this->validate($request, [
            'oldpassword' => 'required',
            'newpassword' => 'required|min:6|confirmed',
        ]);

        if (User::checkMatchPassword($request->input('oldpassword')))
        {

            if (User::changePassword($request->input('oldpassword'), $request->input('newpassword'))) {
                $message = "Password changed";
            } else {
                $message = "New and Old password is equils";
            }

            \Session::flash('flash_message_success',$message);
            $request->session()->flash('status', $message);
            return redirect('profile/changepassword');

        } else {

            \Session::flash('flash_message_error',"Incorrect old password");
            return redirect('profile/changepassword');
        }
    }

}
