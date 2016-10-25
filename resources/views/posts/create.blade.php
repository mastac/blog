@extends('layouts.blogfull')

@section('title-page', 'Add Post')

@section('content')

    {!! Form::open(['url' => 'post/store', 'method' => 'POST']) !!}

    <div class="form-group">
        {!! Form::label('Title') !!}
        {!! Form::text('name', '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Text') !!}
        {!! Form::textarea('text', '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('tag_list','Tags') !!}
        {!! Form::select('tag_list[]', $tags, null, ['class' => 'form-contral', 'multiple', 'id' => 'tag_list']) !!}
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