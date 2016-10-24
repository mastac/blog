@extends('posts.layout')

@section('title-page', 'My Posts')

@section('posts-content')

    @foreach($posts as $post)

        @include('partials.post', ['post' => $post])

    @endforeach

@endsection