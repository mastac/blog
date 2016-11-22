@extends('admin.home')

@section('content')

    <!-- general form elements disabled -->
    <div class="box box-warning">
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group">
                Name: {{$user->name}}
            </div>

            <div class="form-group">
                Email: {{$user->email}}
            </div>

            <div class="form-group" id="tags_edit_post">
                First name: {{$user->first_name}}
            </div>

            <div class="form-group">
                Last name: {{$user->last_name}}
            </div>

            <div class="form-group">
                Activated: {!! ($user->activated) ? "Yes": "NO" !!}
            </div>

            <div class="form-group">
                Is admin: {!! ($user->is_admin) ? "Yes": "NO" !!}
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
