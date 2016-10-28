@if(!empty($post))
<div class="recent-post widget">
    <h3>Related Posts</h3>
    <ul>
        @foreach(\App\Post::getRelatedPosts($post->id) as $relatedPost)
        <li>
            <a href="{{$relatedPost->id}}" title="{{$relatedPost->name}}">{{str_limit($relatedPost->name, 50)}}</a>
        </li>
        @endforeach
    </ul>
</div>
@endif