
<article class="post{{$post->id}} wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">
    <div class="blog-content">

        @if( !empty($post->image))
        <div class="blog-post-image">
        <a href="{{url('posts', $post->id)}}"><img class="img-responsive" src="/storage/{{$post->user_id}}/{{$post->image}}" alt=""></a>
        </div>
        @endif

        <h2 class="blogpost-title">
            <a href="{{url('posts', $post->id)}}">{{$post->name}}</a>
        </h2>

        <div class="blog-meta">
            <span>{{$post->created_at}}</span>
            <span{{ ($post->tags->count() > 0 || $post->comments_count > 0)  ? '' : " class=last" }}>
                by <a href="{{url('user', $post->user()->first()->name)}}">{{$post->user()->first()->name}}</a>
            </span>
            @if ($post->tags->count() > 0)
                <span{{ ($post->comments_count > 0) ? "" : " class=last" }}>
                {!! \App\Helpers\Nav::getTagLinks("tags/" , $post->tags()->pluck('name')) !!}
            </span>
            @endif
            @if ($post->comments_count > 0)
                <span class="last">
                {{$post->comments_count}} comments
            </span>
            @endif
        </div>

        <div>{!! str_limit(strip_tags($post->text), 250) !!}</div>

        <div>
            <a href="{{url('posts', $post->id)}}" class="btn btn-dafault btn-details">Continue Reading</a>

            @if (Auth::id() == $post->user_id)
                <a href="{{url('posts/edit',$post->id)}}" name="edit-post-{{$post->id}}" class="btn btn-dafault btn-details">Edit post</a>
                <a href="{{url('posts/delete',$post->id)}}" id="delete-post-{{$post->id}}" class="btn btn-dafault btn-details btn-delete">Delete post</a>
            @endif

            <a href="javascript:void(0);" data-postid="{{$post->id}}" class="like btn btn-dafault btn-details glyphicon glyphicon-thumbs-up">&nbsp;{{$post->like}}</a>
            <a href="javascript:void(0);" data-postid="{{$post->id}}" class="dislike btn btn-dafault btn-details glyphicon glyphicon-thumbs-down">&nbsp;{{$post->dislike}}</a>
        </div>
    </div>
</article>
