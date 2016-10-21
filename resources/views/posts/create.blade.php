@extends('posts.layout')

@section('posts-content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add post</div>
                <div class="panel-body">

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

                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

    <script type="text/javascript">

        $('#tag_list').select2();

    </script>

@endsection