@extends('layouts.blog')

@section('title-page', 'Home page')

@section('global_page_header')

    @include('partials.global_page_header')

@endsection

@section('content')

    @forelse($posts as $post)

        @include('partials.post', ['post' => $post])

    @empty

        <article class="wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">Empty</article>

    @endforelse

@endsection

@section('script')

    @include('partials.script_scroll', ['entry' => 'home'])

@endsection
