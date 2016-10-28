@if (count(\App\Tag::getTagsWithCountPosts()) > 0)
<div class="categories widget">
    <h3 class="widget-head">Tags</h3>
    <ul>
        @foreach(\App\Tag::getTagsWithCountPosts() as $tag)
        <li>
            <a href="{{url('tags',$tag->name)}}">{{$tag->name}}</a> <span class="badge">{{$tag->posts_count}}</span>
        </li>
        @endforeach
    </ul>
</div>
@endif