<section class="single-post">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if(isset($post->text))
                <div class="post-img">
                    <img class="img-responsive" alt="" src="{{$post->image}}">
                </div>
                @endif

                <div class="post-content">
                {{$post->text}}
                </div>

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
            <div class="col-md-12">
                <div class="comments">
                @include('partials.loading')
                </div>
                <div class="post-comment">
                    <h3>Leave a Reply</h3>
                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-lg-6">
                                <input type="text" class="col-lg-12 form-control" placeholder="Name">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="col-lg-12 form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <textarea class=" form-control" rows="8" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <p>
                        </p>
                        <p>
                            <button class="btn btn-send" type="submit">Comment</button>
                        </p>

                        <p></p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>