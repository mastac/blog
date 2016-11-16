
@foreach($comments as $comment)

    <div class="media">
        <div class="media-body">
            <h4 class="media-heading"> {{$comment->name}} </h4>
            <div class="text-muted">
                {{$comment->created_at}}
            </div>
            <p>
                {{$comment->comment}}
            </p>
        </div>
        <div>
            <a href="javascript:void(0);" data-commentid="{{$comment->id}}" class="like glyphicon glyphicon-thumbs-up">&nbsp;{{$comment->like}}</a>
            &nbsp;/&nbsp;
            <a href="javascript:void(0);" data-commentid="{{$comment->id}}" class="dislike glyphicon glyphicon-thumbs-down last">&nbsp;{{$comment->dislike}}</a>
        </div>
    </div>

@endforeach