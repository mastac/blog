@php
    $tags = (new \App\Tag)->getTagsWithCountPosts();
@endphp

@if ($tags->count() > 0)
<div class="categories widget">
    <h3 class="widget-head">Tags</h3>
    <ul>
        @foreach($tags as $tag)
        <li>
            <a href="{{url('tags',$tag->name)}}">{{$tag->name}}</a> <span class="badge">{{$tag->posts_count}}</span>
        </li>
        @endforeach
    </ul>
</div>
@endif