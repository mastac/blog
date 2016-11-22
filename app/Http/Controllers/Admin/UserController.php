<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users', ['page_title'=>'Users', 'page_subtitle'=>'list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create')
            ->with('page_title', 'Users')
            ->with('page_subtitle', 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_data = $request->all();
        $user_data['password'] = bcrypt($user_data['password']);
        User::create($user_data);
        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = \App\User::find($id);
        return view('admin.users.show')->with('user', $user)
            ->with('page_title', 'Users')
            ->with('page_subtitle', 'show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('socialAccount')->find($id);
        return view('admin.users.edit')->with('user', $user)
            ->with('page_title', 'Users')
            ->with('page_subtitle', 'edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $attributes = $request->all();

        // Password
        if (isset($attributes['password']) && empty($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        }

        // Is admin
        if (!isset($attributes['is_admin'])) {
            $attributes['is_admin'] = false;
        }

        // Activated
        if (!isset($attributes['activated'])) {
            $attributes['activated'] = false;
        }

        $user->update($attributes);

        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\User::findOrFail($id)->destroy($id);
        return redirect('admin/users');
    }
}
