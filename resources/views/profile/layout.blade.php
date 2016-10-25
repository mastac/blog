@extends('layouts.blogfull')

@section('title-page', 'Profile')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="{{\App\Helpers\Nav::setActive('profile', $request)}}"><a href="{{ url('/profile') }}">Profile info</a></li>
                <li role="presentation" class="{{\App\Helpers\Nav::setActive('profile/changepassword', $request)}}"><a href="{{ url('/profile/changepassword') }}">Change password</a></li>
            </ul>
        </div>
        <div class="col-md-8">
            @yield('profile-content')
        </div>
    </div>

@endsection