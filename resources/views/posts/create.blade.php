@extends('layouts.blogfull')

@section('title-page', 'Add Post')

@section('global_page_header')

    @include('partials.global_page_header')

@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
        {!! Form::submit('Save', ['class' => 'btn btn-details']) !!}
        {!! Html::link('posts', 'Cancel', ['class' => 'btn btn-details']) !!}
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