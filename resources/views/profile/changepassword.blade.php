@extends('profile.layout')

@section('title-page', 'Change password')

@section('profile-content')

    @if (session()->has('flash_message_success'))
    <div class="alert alert-success">
        {!! session('flash_message_success') !!}
    </div>
    @endif

    @if (session()->has('flash_message_error'))
        <div class="alert alert-warning">
            {!! session('flash_message_error') !!}
        </div>
    @endif

    {!! Form::open(['url' => 'profile/changepassword', 'method' => 'POST']) !!}

    <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
        {!! Form::label('Old password') !!}
        {!! Form::password('oldpassword', ['class' => 'form-control']) !!}
        @if ($errors->has('newpassword'))
            <span class="help-block">
                <strong>{{ $errors->first('oldpassword') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
        {!! Form::label('New password') !!}
        {!! Form::password('newpassword', ['class' => 'form-control']) !!}
        @if ($errors->has('newpassword'))
            <span class="help-block">
                <strong>{{ $errors->first('newpassword') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('Confirm password') !!}
        {!! Form::password('newpassword_confirmation', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Change password', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

@endsection