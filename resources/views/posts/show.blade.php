@extends('layouts.blog')

@section('title-page', $post->name)

@section('global_page_header')

    @include('partials.global_page_header')

@endsection

@section('content')

<section class="single-post">

    {{--<div class="post-img">--}}
        {{--<img class="img-responsive" alt="" src="http://loremflickr.com/1140/470">--}}
    {{--</div>--}}

    <div class="post-content">
        {!! $post->text  !!}
    </div>

    @if (count($post->tags()->pluck('name')) > 0)
    <div id="tag-list">
        <strong>Tags:</strong>
        @foreach($post->tags()->pluck('name') as $tag)
            <a href="{{url('tag',$tag)}}">{{$tag}}</a>
        @endforeach
    </div>
    @endif

    @if (Auth::id() == $post->user_id)
    <div id="actions">
        <a href="{{url('post/edit',$post->id)}}" class="btn btn-dafault btn-details">Edit post</a>
        <a href="{{url('post/delete',$post->id)}}" class="btn btn-dafault btn-details btn-delete">Delete post</a>
    </div>
    @endif

    <div id="comments"><img src="/images/loading.gif" alt="Loading..."></div>

    <div class="post-comment">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h3>Leave a Reply</h3>
        {!! Form::open(['url' => 'comment/add', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        {!! Form::hidden('post_id', $post->id) !!}

            <div class="form-group">
                <div class="col-lg-6">
                    {!! Form::text('name', null, ['class' => 'col-lg-12 form-control', 'placeholder' => 'Name']) !!}
                </div>
                <div class="col-lg-6">
                    {!! Form::text('email', null, ['class' => 'col-lg-12 form-control', 'placeholder' => 'Email']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '8', 'placeholder' => 'Message']) !!}
                </div>
            </div>
            <p>
            </p>
            <p>
                {!! Form::submit('Comment', ['class' => 'btn btn-send']) !!}
            </p>

            <p></p>
        {!! Form::close() !!}

    </div>
</section>
@endsection

@section('script')

    <script type="text/javascript">

        $(function(){

            $.ajax({
                url: '/comments/{{$post->id}}',
                success: function(data) {
                    $('#comments').html(data);
                }

            });

        });

    </script>

@endsection