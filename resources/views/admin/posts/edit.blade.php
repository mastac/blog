@extends('admin.home')

@section('content')

    <!-- general form elements disabled -->
    <div class="box box-warning">
        <!-- /.box-header -->
        <div class="box-body">

        @include('partials.error_flash')

        {!! Form::open(['url' => '/admin/posts/' . $post->id, 'method' => 'put', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', $post->name, ['class' => 'form-control', 'id' => 'Title']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Text') !!}
            {!! Form::textarea('text', $post->text, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group" id="tags_edit_post">
            {!! Form::label('tag_list','Tags') !!}
            {!! Form::select('tag_list[]', $tags, $post->tag_list, ['class' => 'form-contral', 'multiple', 'id' => 'tag_list']) !!}
        </div>

        <div class="form-group">
            @if (!empty($post->image))
                <div>
                    {!! Html::image('storage/' . $post->user_id . '/' . $post->image) !!}
                </div>
            @endif
            {!! Form::label('image', 'Image') !!}
            {!! Form::file('image') !!}
        </div>

        <div class="form-group">
            {!! Form::label('youtube', 'Link on youtube video') !!}
            {!! Form::text('youtube', $post->youtube, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Save', ['class' => 'btn btn-primary', 'id' => 'create_post_button']) !!}
            {!! Html::link('admin/posts', 'Cancel', ['class' => 'btn btn-default']) !!}
        </div>

        {!! Form::close() !!}

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection

@push('scripts-footer')

<script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>

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