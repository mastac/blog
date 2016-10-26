<div class="sidebar">

    <div class="search widget">
        <form action="{{url("search")}}" method="get" class="searchform" role="search">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"> <i class="ion-search"></i> </button>
                </span>
            </div><!-- /input-group -->
        </form>
    </div>

    @if (Request::is('post/*') && \App\Post::getRelatedPosts($post->id)->count() > 0)
    <div class="recent-post widget">
        <h3>Related Posts</h3>
        <ul>
            @foreach(\App\Post::getRelatedPosts($post->id) as $relatedPost)
            <li>
                <a href="{{url('post', $relatedPost->id)}}">{{$relatedPost->name}}</a><br>
                <time>{{$relatedPost->created_at}}</time>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

</div>