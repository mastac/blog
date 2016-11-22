@extends('admin.home')

@section('content')

    <!-- general form elements disabled -->
    <div class="box box-warning">
        <!-- /.box-header -->
        <div class="box-body">

            @include('partials.error_flash')

            {!! Form::open(['url' => 'admin/users/' . $user->id, 'method' => 'put']) !!}


            <div class="form-group">
                {!! Form::label('Login') !!}
                {!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'login']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('Email') !!}
                {!! Form::email('email', $user->email, ['class' => 'form-control', 'id' => 'email']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                @if(is_null($user->socialAccount))
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'last_name']) !!}
                @else
                    password not required, because use social account
                @endif
            </div>

            <div class="form-group" id="tags_edit_post">
                {!! Form::label('First name') !!}
                {!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'id' => 'first_name']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('last_name', 'Last name') !!}
                {!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'id' => 'last_name']) !!}
            </div>

            @if(is_null($user->socialAccount))
            <div class="form-group">
                {!! Form::label('activated', 'Activated') !!}
                {!! Form::checkbox('activated', 1, $user->activated) !!}
            </div>
            @endif

            <div class="form-group">
                {!! Form::label('is_admin', 'Is admin') !!}
                {!! Form::checkbox('is_admin', 1, $user->is_admin) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-details', 'id' => 'edit_user_button']) !!}
                {!! Html::link('admin/users', 'Cancel', ['class' => 'btn btn-details']) !!}
            </div>

            {!! Form::close() !!}

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
