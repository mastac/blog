<!--
==================================================
Global Page Section Start
================================================== -->
<section class="global-page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <h2>{{ isset($page_title) ? $page_title : "" }}</h2>

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

                    @if(isset($post_meta))
                    <div class="portfolio-meta">
                        <span>Dec 11, 2020</span>|
                        <span> by: username</span>|
                        <span> Tags: <a href="">business</a>,<a href="">people</a></span>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section><!--/#Page header-->