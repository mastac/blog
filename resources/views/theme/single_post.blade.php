@extends('layouts.two_columns')

@section('content')

<section class="single-post">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                @if(!empty($post->image))
                <div class="post-img">
                    <img class="img-responsive" alt="" src="/storage/{{$post->user_id}}/{{$post->image}}">
                </div>
                @endif

                <div class="post-content">
                    {!! $post->text !!}
                </div>

                @if(!empty($post->youtube_url))
                <div class="post-youtube">
                    <h4>Video for this post</h4>
                    <iframe width="100%" height="480" src="https://www.youtube.com/embed/{!! $post->youtube_url !!}" frameborder="0" allowfullscreen></iframe>
                </div>
                @endif

                <ul class="social-share">
                    <h4>Share this article</h4>
                    <li>
                        <a href="#" class="Facebook">
                            <i class="ion-social-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="Twitter">
                            <i class="ion-social-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="Linkedin">
                            <i class="ion-social-linkedin"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="Google Plus">
                            <i class="ion-social-googleplus"></i>
                        </a>
                    </li>

                </ul>

            </div>
        </div>
        <div class="row">
            <div class="col-md-8">

                <div class="comments" id="comments">
                @include('partials.loading')
                </div>

                <div id="post-comment" class="post-comment">

                    @include('partials.error_flash')

                    <h3>Leave a Reply</h3>

                    {!! Form::open(['url' => 'comment/add', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    {!! Form::hidden('post_id', $post->id) !!}

                    <div class="form-group">
                        <div class="col-lg-6">
                            {!! Form::text('name', null, ['class' => 'col-lg-12 form-control', 'placeholder' => 'Name', 'id' => 'comment_name']) !!}
                        </div>
                        <div class="col-lg-6">
                            {!! Form::text('email', null, ['class' => 'col-lg-12 form-control', 'placeholder' => 'Email', 'id' => 'comment_email']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '8', 'placeholder' => 'Message', 'id' => 'comment_message']) !!}
                        </div>
                    </div>
                    <p>
                    </p>
                    <p>
                        {!! Form::submit('Comment', ['class' => 'btn btn-send', 'id' => 'comment_save_button']) !!}
                    </p>

                    <p></p>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')

    <script type="text/javascript">

        $(function(){

            $.ajax({
                url: '/comments/{{$post->id}}',
                success: function(data) {
                    $('.comments').html(data);
                }

            });

        });

    </script>

@endpush