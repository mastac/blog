@extends('layouts.blog')

@section('title-page', 'My Posts')

@section('content')

    @forelse($posts as $post)

        @include('partials.post', ['post' => $post])

    @empty

        Empty

    @endforelse

@endsection