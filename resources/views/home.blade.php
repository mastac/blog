@extends('layouts.blog')

@section('title-page', 'Home page')

@section('content')

    @forelse($posts as $post)

        @include('partials.post', ['post' => $post])

    @empty

        <article class="wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">Empty</article>

    @endforelse

@endsection

@section('script')

    <script type="text/javascript">

        $(function () {

            var win = $(window);

            var limit = 5;

            var offset = 5;

            var enabledScroll = true;

            var is_run = false;

            // Each time the user scrolls
            win.scroll(function () {
                if (enabledScroll) {
                    // End of the document reached?
                    console.log(($(document).height() - win.height()), win.scrollTop() + 370);
                    if (($(document).height() - win.height()) < (win.scrollTop() + 370)) {
                        if(!is_run) {
                            is_run = true;
                            $.ajax({
                                url: '/posts/getposttoscroll/' + offset + '/' + limit,
                                dataType: 'html',
                                success: function (html) {
                                    if (html) {
                                        offset = offset + limit;
                                        $('#posts').append(html);
                                        is_run = false;
                                    } else {
                                        enabledScroll = false;
                                    }
                                }
                            });
                        }
                    }
                }// enabledScroll
            });

        })

    </script>

@endsection
