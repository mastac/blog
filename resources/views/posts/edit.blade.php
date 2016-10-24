@extends('posts.layout')

@section('title-page', 'Edit Post')

@section('posts-content')

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
        {!! Form::label('tag_list','Tags') !!}
        {!! Form::select('tag_list[]', $tags, $post->tag_list, ['class' => 'form-contral', 'multiple', 'id' => 'tag_list']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        {!! Html::link('posts', 'Cancel', ['class' => 'btn']) !!}
    </div>

    {!! Form::close() !!}


@endsection


@section('script')

    <script type="text/javascript">

        $(function(){
            $('#tag_list').select2({
                placeholder: 'Choose a tag',
                allowClear: true,
                tags: true
            });
        });

    </script>

@endsection