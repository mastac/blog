
<article class="wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">
    <div class="blog-content">

        {{--<div class="blog-post-image">--}}
            {{--<a href="{{url('post', $post->id)}}"><img class="img-responsive" src="http://loremflickr.com/750/300" alt=""></a>--}}
        {{--</div>--}}

        <h2 class="blogpost-title">
            <a href="{{url('post', $post->id)}}">{{$post->name}}</a>
        </h2>

        <div class="blog-meta">
            <span>{{$post->created_at}}</span>
            <span{{ ($post->tags->count() > 0 || $post->comments_count > 0)  ? '' : " class=last" }}>
                by <a href="{{url('user', $post->user()->first()->name)}}">{{$post->user()->first()->name}}</a>
            </span>
            @if ($post->tags->count() > 0)
            <span{{ ($post->comments_count > 0) ? "" : " class=last" }}>
                {!! \App\Helpers\Nav::getTagLinks($post->tags) !!}
            </span>
            @endif
            @if ($post->comments_count > 0)
            <span class="last">
                {{$post->comments_count}} comments
            </span>
            @endif
        </div>

        <div>{!! str_limit(strip_tags($post->text), 250) !!}</div>

        <a href="{{url('post', $post->id)}}" class="btn btn-dafault btn-details">Continue Reading</a>

        @if (Auth::id() == $post->user_id)
            <a href="{{url('post/edit',$post->id)}}" class="btn btn-dafault btn-details">Edit post</a>
            <a href="{{url('post/delete',$post->id)}}" class="btn btn-dafault btn-details btn-delete">Delete post</a>
        @endif

    </div>
</article>
