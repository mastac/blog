@extends('layouts.two_columns')

@section('content')

    <div id="posts">
        @each('theme.post', $posts, 'post', 'posts.empty')
    </div>

@endsection