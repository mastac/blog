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
                    {!! Form::label('tag_list','Tags') !!}
                    {!! Form::select('tag_list[]', $tags, $post->tag_list, ['class' => 'form-contral', 'multiple', 'id' => 'tag_list']) !!}
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


@section('script')

    <script type="text/javascript">

        /* Note: пока не работает добавление тэгов */
        $('#tag_list').select2({
            placeholder: 'Choose a tag',
            allowClear: true,
            /*ajax: {
                url: "/tag/add",
                cache: false,
                dataType: 'json',
                delay: 250,
                data: function(params){
                    q: params.term
                },
                prosessResult: function(data) {
                    return { results: data }
                }
            }, */
            tags: true
        });

    </script>

@endsection