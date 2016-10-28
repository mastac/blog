<div class="recent-post widget">
    <h3>Recent Posts</h3>
    <ul>
        @foreach(\App\Post::orderBy('created_at','desc')->take(5)->get(['id', 'name', 'created_at']) as $recentPost)
        <li>
            <a href="/posts/{{$recentPost->id}}" title="{{$recentPost->name}}">{{str_limit($recentPost->name, 50)}}</a><br>
            <time>{{$recentPost->created_at}}</time>
        </li>
        @endforeach
    </ul>
</div>