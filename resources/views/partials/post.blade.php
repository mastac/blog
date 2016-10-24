
<article class="wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">
    <div class="blog-content">
        <h2 class="blogpost-title">
            <a href="{{url('post', $post->id)}}">{{$post->name}}</a>
        </h2>
        <div class="blog-meta">
            <span>{{$post->created_at}}</span>
            <span>by <a href="#">{{$post->user()->first()->first_name}} {{$post->user()->first()->last_name}}</a></span>
            <span>
                    @foreach($post->tags()->pluck('name','id')->toArray() as $tag)
                    <a href="{{url('tag',$tag)}}">{{$tag}}</a>,
                @endforeach
                </span>
        </div>
        <p>{{$post->text}}</p>
        <a href="{{url('post', $post->id)}}" class="btn btn-dafault btn-details">Continue Reading</a>

        @if (Auth::id() == $post->user_id)
            <a href="{{url('post/edit',$post->id)}}" class="btn btn-dafault btn-details">Edit post</a>
            <a href="{{url('post/delete',$post->id)}}" class="btn btn-dafault btn-details">Delete post</a>
        @endif
    </div>
</article>
