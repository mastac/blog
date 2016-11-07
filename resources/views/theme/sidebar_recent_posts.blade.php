@php
    $recentPosts = (new \App\Post)->getRecentPosts();
@endphp

@if ($recentPosts->count() > 0)
<div class="recent-post widget">
    <h3>Recent Posts</h3>
    <ul>
        @foreach($recentPosts as $recentPost)
        <li>
            <a href="/posts/{{$recentPost->id}}" title="{{$recentPost->name}}">{{str_limit($recentPost->name, 50)}}</a><br>
            <time>{{$recentPost->created_at}}</time>
        </li>
        @endforeach
    </ul>
</div>
@endif