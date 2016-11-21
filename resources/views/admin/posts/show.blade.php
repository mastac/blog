@extends('admin.home')

@section('content')

    <!-- general form elements disabled -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Show post (Example: display source of fields, but I think need redirect to frontend show this page)</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="form-group">
                <strong>Name:</strong> {{$post->name}}
            </div>

            <div class="form-group">
                <strong>Text:</strong> {{$post->text}}
            </div>

            <div class="form-group" id="tags_edit_post">
                <strong>Tags:</strong>
                {{implode(', ', $post->tag_list)}}
            </div>

            <div class="form-group">
                <strong>Image:</strong> {!! Html::image('storage/' . $post->user_id . '/' . $post->image) !!}
            </div>

            <div class="form-group">
                <strong>Youtube:</strong> {{$post->youtube}}
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->


@endsection
