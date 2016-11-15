<!--
==================================================
Global Page Section Start
================================================== -->
<section class="global-page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">

                    <h2 id="global_page_title">{{ !empty($page_title) ? $page_title : "" }}</h2>
                    <h2>@yield('page_title')</h2>

                    @if(isset($breadcrumb))
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url("/")}}">
                                <i class="ion-ios-home"></i>
                                Home
                            </a>
                        </li>
                        <li class="active">Blog</li>
                    </ol>
                    @endif

                    @if(!empty($post))
                    <div class="portfolio-meta">
                        <span>{{$post->created_at}}</span>
                        |<span> by: {!! Html::link("user/{$post->user->name}", $post->user->name) !!}</span>
                        @if(count($post->tags) > 0)
                        |<span> Tags: {!! \App\Helpers\Nav::getTagLinks("tags/", $post->tags()->pluck('name')) !!}</span>
                        @endif
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section><!--/#Page header-->