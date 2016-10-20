@extends('posts.layout')

@section('posts-content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit post</div>
                <div class="panel-body">

                {!! Form::open(['url' => 'post/store', 'method' => 'POST']) !!}
                {!! Form::token() !!}
                {!! Form::hidden('id', $post->id) !!}

                <div class="form-group">
                    {!! Form::label('Title') !!}
                    {!! Form::text('name', $post->name, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('Text') !!}
                    {!! Form::textarea('text', $post->text, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('Tags') !!}
                    {!! Form::select('tags[]', $tags, null, ['class' => 'form-contral', 'multiple']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    {!! Html::link('posts', 'Cancel', ['class' => 'btn']) !!}
                </div>

                {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection