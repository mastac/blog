<!DOCTYPE html>
<html class="no-js">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <title>{{ isset($page_title) ? $page_title : "Timer Agency Template" }} - {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Template CSS Files
    ================================================== -->
    <link rel="stylesheet" href="{{ elixir('css/blog.css') }}">

    <!-- Template Javascript Files
    ================================================== -->
    <script src="{{ elixir('js/blog.js') }}"></script>

    <!-- Template Javascript Custom
    ================================================== -->
    @stack('scripts')

</head>
<body>

@include('theme.top_bar')

@yield('main-content')

{{--@include('theme.call_to_action')--}}

@include('theme.footer')

</body>
</html>