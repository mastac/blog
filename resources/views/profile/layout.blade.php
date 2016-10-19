@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-4">
                            <ul class="nav nav-pills nav-stacked">
                                <li role="presentation" class="active"><a href="{{ url('/profile') }}">Profile info</a></li>
                                <li role="presentation"><a href="{{ url('/profile/changepassword') }}">Change password</a></li>
                            </ul>
                        </div>
                        <div class="col-md-8">
                            @yield('profile-content')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection