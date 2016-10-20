@extends('posts.layout')

@section('posts-content')

    <a href="{{url('post/create')}}" class="btn btn-primary">Add new post</a>

    @foreach($posts as $post)

        <div>
            <div>
                {{$post->name}}
            </div>
            <div>
                {{$post->text}}
            </div>
        </div>

    @endforeach

@endsection