@extends('layouts.two_columns')

@section('content')

    @include('partials.error_flash')

    <div id="posts">
    @each('theme.post', $posts, 'post')
    </div>

    @include('partials.loading', ['show' => 0])

@endsection

@push('scripts')

    @include('partials.script_scroll', ['scroll_url' => $scroll_url])

@endpush