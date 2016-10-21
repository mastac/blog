@extends('posts.layout')

@section('posts-content')

    <a href="{{url('post/create')}}" class="btn btn-primary">Add new post</a>

    @foreach($posts as $post)

        <div>
            <h2>
                <a href="{{url('post', $post->id)}}">{{$post->name}}</a>
            </h2>
            <div>
                {{$post->text}}
            </div>
            <div>
                @foreach($post->tags()->pluck('name','id')->toArray() as $tag)
                    <a href="{{url('tag',$tag)}}">{{$tag}}</a>
                @endforeach
            </div>
            <div>
                <a href="{{url('post/edit',$post->id)}}">Edit post</a>
                <a href="{{url('post/delete',$post->id)}}">Delete post</a>
            </div>
        </div>

    @endforeach

@endsection