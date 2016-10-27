<section id="blog-full-width">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            @yield('content')
            </div>
            <div class="col-md-4">
                <div class="sidebar">
                    @include('theme.sidebar_search')
                    @include('theme.sidebar_categories')
                    @include('theme.sidebar_posts')
                </div>
            </div>
        </div>
    </div>
</section>