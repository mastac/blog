@if(!empty($post) && count($post->getRelatedPosts(5)) > 0)
<div class="recent-post widget">
    <h3>Related Posts</h3>
    <ul>
        @foreach($post->getRelatedPosts(5) as $relatedPost)
        <li>
            <a href="{{$relatedPost->id}}" title="{{$relatedPost->name}}">{{str_limit($relatedPost->name, 50)}}</a>
        </li>
        @endforeach
    </ul>
</div>
@endif