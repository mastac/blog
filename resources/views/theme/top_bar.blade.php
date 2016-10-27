<!--
==================================================
Header Section Start
================================================== -->
<header id="top-bar" class="navbar-inverse navbar-fixed-top animated-header">
    <div class="container">
        <div class="navbar-header">
            <!-- responsive nav button -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- /responsive nav button -->

            <!-- logo -->
            <div class="navbar-brand">
                <a href="{{url("/")}}" >
                    <img src="/images/logo.png" alt="">
                </a>
            </div>
            <!-- /logo -->
        </div>
        <!-- main menu -->
        <nav class="collapse navbar-collapse navbar-right" role="navigation">
            <div class="main-menu">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{url('/register')}}">Sign up</a></li>
                        <li><a href="{{url('/login')}}">Sign in</a></li>
                    @else
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/myposts/create') }}">Create post</a></li>
                        <li><a href="{{ url('/myposts') }}">My Posts</a></li>
                        <li><a href="{{ url('/profile') }}">Profile </a></li>
                        <li><a href="{{ url('/logout') }}"onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                                Logout
                            </a></li>
                    @endif
                </ul>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </nav>
        <!-- /main nav -->
    </div>
</header>