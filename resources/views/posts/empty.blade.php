<article class="wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">
    <div class="blog-content">
        <h2 class="blogpost-title">
            Not yet any posts.
        </h2>
        @if (Auth::check())
            <a href="{{url('myposts/create')}}" class="btn btn-dafault btn-details">Add new post</a>
        @endif
    </div>
</article>