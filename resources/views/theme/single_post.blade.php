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

<!-- Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you want delete this?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

    <script type="text/javascript">

        $(function(){

            // loading comments after loaded page
            $.ajax({
                url: '/comments/{{$post->id}}',
                success: function(data) {
                    $('.comments').html(data);
                }

            });

            // like
            $('body').on('click', 'a.like', function(e){

                $.ajax({
                    url: '/ajax/comments/like/' + $(e.target).data().commentid,
                    success: function(data) {
                        $(e.target).parent().find('a.like').html('&nbsp;' + data.like);
                        $(e.target).parent().find('a.dislike').html('&nbsp;' + data.dislike);
                    }
                });

                // dislike
            }).on('click', 'a.dislike', function(e){

                $.ajax({
                    url: '/ajax/comments/dislike/' + $(e.target).data().commentid,
                    success: function(data) {
                        $(e.target).parent().find('a.like').html('&nbsp;' + data.like);
                        $(e.target).parent().find('a.dislike').html('&nbsp;' + data.dislike);
                    }
                });


            });

            // delete comments by owner of post
            $('#confirmDelete').on('show.bs.modal', function (event) {
                var link_delete = $(event.relatedTarget);
                var modal = $(this);
                modal.find('.modal-footer button.btn-primary').off();
                modal.find('.modal-footer button.btn-primary').on('click', function(e) {
                    modal.modal('hide');
                    $.ajax({
                        url: '/ajax/comments/delete/' + link_delete.data().commentid,
                        success: function(data) {
                            if (data.status) {
                                $('#comments').find('.media[data-commentid='+data.commentid+']').remove()
                            }
                        }
                    });
                });
            });

        });

    </script>

@endpush