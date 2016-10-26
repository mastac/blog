@extends('layouts.blog')

@section('title-page', (isset($title_page) ? $title_page : 'My Posts'))

@section('global_page_header')

    @include('partials.global_page_header')

@endsection

@section('content')

    @forelse($posts as $post)

        @include('partials.post', ['post' => $post])

    @empty

        Empty

    @endforelse

@endsection