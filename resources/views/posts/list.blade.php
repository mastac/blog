@extends('posts.layout')

@section('posts-content')

    <a href="{{url('post/create')}}" class="btn btn-primary">Add new post</a>

    @foreach($posts as $post)

        <div>
            <h2>
                {{$post->name}}
            </h2>
            <div>
                {{$post->text}}
            </div>
            <div>
                <a href="{{url('post/edit/')}}/{{$post->id}}">Edit post</a>
            </div>
        </div>

    @endforeach

@endsection