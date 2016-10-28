
@foreach($posts as $post)

    @include('theme.post', ['post' => $post])

@endforeach