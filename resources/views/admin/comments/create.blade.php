@extends('admin.home')

@section('content')

<!-- general form elements disabled -->
<div class="box box-warning">
    <!-- /.box-header -->
    <div class="box-body">

        @include('partials.error_flash')

        {!! Form::open(['url' => 'admin/comments', 'method' => 'POST', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('Post') !!}
            {!! Form::select('post_id', $posts, '', ['class' => 'form-control', 'id' => 'Post']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('name') !!}
            {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'name']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email') !!}
            {!! Form::email('email', '', ['class' => 'form-control', 'id' => 'email']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('comment') !!}
            {!! Form::textarea('comment', '', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Save', ['class' => 'btn btn-details', 'id' => 'create_post_button']) !!}
            {!! Html::link('admin/comments', 'Cancel', ['class' => 'btn btn-details']) !!}
        </div>

        {!! Form::close() !!}

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

@endsection
