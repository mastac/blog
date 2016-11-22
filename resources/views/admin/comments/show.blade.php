@extends('admin.home')

@section('content')

    <!-- general form elements disabled -->
    <div class="box box-warning">
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group">
                <strong>Name:</strong> {{$comment->name}}
            </div>

            <div class="form-group">
                <strong>Comment:</strong> {{$comment->comment}}
            </div>

            <div class="form-group">
                <strong>Created at:</strong> {{$comment->created_at}}
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->


@endsection
