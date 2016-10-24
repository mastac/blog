
<nav class="collapse navbar-collapse navbar-right" role="navigation">
    <div class="main-menu">
        <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <li><a href="{{url('/register')}}">Sign up</a></li>
                <li><a href="{{url('/login')}}">Sign in</a></li>
            @else
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/post/create') }}">Add Post</a></li>
                <li><a href="{{ url('/posts') }}">My Posts </a></li>
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