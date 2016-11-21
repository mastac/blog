@extends('admin.home')

@section('content')

    <!-- general form elements disabled -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Create post</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            @include('partials.error_flash')

            {!! Form::open(['url' => 'admin/users', 'method' => 'POST', 'files' => true]) !!}


            <div class="form-group">
                {!! Form::label('Login') !!}
                {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'login']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('Email') !!}
                {!! Form::email('email', '', ['class' => 'form-control', 'id' => 'email']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'last_name']) !!}
            </div>

            <div class="form-group" id="tags_edit_post">
                {!! Form::label('First name') !!}
                {!! Form::text('first_name', '', ['class' => 'form-control', 'id' => 'first_name']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('last_name', 'Last name') !!}
                {!! Form::text('last_name', '', ['class' => 'form-control', 'id' => 'last_name']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('activated', 'Activated') !!}
                {!! Form::checkbox('activated') !!}
            </div>

            <div class="form-group">
                {!! Form::label('is_admin', 'Is admin') !!}
                {!! Form::checkbox('is_admin') !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-details', 'id' => 'create_user_button']) !!}
                {!! Html::link('admin/users', 'Cancel', ['class' => 'btn btn-details']) !!}
            </div>

            {!! Form::close() !!}

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
