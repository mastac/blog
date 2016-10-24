@extends('posts.layout')

@section('title-page', $post->name)

@section('posts-content')

{{$post->text}}

<div>
    @foreach($post->tags()->pluck('name','id')->toArray() as $tag)
        <a href="{{url('tag',$tag)}}">{{$tag}}</a>
    @endforeach
</div>


<div class="panel-body">
<h3>Comments</h3>

<div id="comments">

@foreach($comments as $comment)

    <div style="margin:10px 0">
        <div>{{$comment->name}}</div>
        <div>{{$comment->email}}</div>
        <div>{{$comment->comment}}</div>
    </div>

@endforeach

</div>

<h4>Send comments</h4>

{!! Form::open(['url' => 'comment/add', 'method' => 'POST']) !!}
{!! Form::hidden('post_id', $post->id) !!}

<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('comment', 'Comment') !!}
    {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

</div>

@endsection