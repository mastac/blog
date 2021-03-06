@extends('layouts.one_column')

@section('content')

    @include('partials.error_flash')

    {!! Form::open(['url' => 'posts/store', 'method' => 'POST', 'files' => true]) !!}


    <div class="form-group">
        {!! Form::label('Title') !!}
        {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'Title']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Text') !!}
        {!! Form::textarea('text', '', ['class' => 'form-control tinymce']) !!}
    </div>

    <div class="form-group" id="tags_edit_post">
        {!! Form::label('tag_list','Tags') !!}
        {!! Form::select('tag_list[]', $tags, null, ['class' => 'form-contral', 'multiple', 'id' => 'tag_list']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('image', 'Image') !!}
        {!! Form::file('image') !!}
    </div>

    <div class="form-group">
        {!! Form::label('youtube', 'Link on youtube video') !!}
        {!! Form::text('youtube', '', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-details', 'id' => 'create_post_button']) !!}
        {!! Html::link('user/' . \Auth::user()->name, 'Cancel', ['class' => 'btn btn-details']) !!}
    </div>

    {!! Form::close() !!}

@endsection

@push('scripts')
<script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>
@endpush

@push('scripts')

    <script type="text/javascript">

        $(function(){

            $('#tag_list').select2({
                placeholder: 'Choose a tag',
                allowClear: true,
                tags: true
            });

            tinymce.init({
                selector: 'textarea',
                height: 500,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                content_css: '/js/tinymce/css/codepen.min.css'
            });

        });

    </script>

@endpush