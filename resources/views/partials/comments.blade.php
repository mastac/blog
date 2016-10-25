
@foreach($comments as $comment)

    <div class="media">
        <div class="media-body">
            <h4 class="media-heading"> {{$comment->name}} </h4>
            <p class="text-muted">
                {{$comment->created_at}}
            </p>
            <p>
                {{$comment->comment}}
            </p>
        </div>
    </div>

@endforeach