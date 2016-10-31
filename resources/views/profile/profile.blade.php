@extends('profile.layout')

@section('title-page', 'Profile')

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

    {!! Form::open(['url' => 'profile', 'method' => 'POST']) !!}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::label('Login') !!}
        {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
        {!! Form::label('First name') !!}
        {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
        @if ($errors->has('first_name'))
            <span class="help-block">
                <strong>{{ $errors->first('first_name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
        {!! Form::label('Last name') !!}
        {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
        @if ($errors->has('last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('Email') !!}
        {!! Form::text('email', $user->email, ['class' => 'form-control', 'readonly']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

@endsection