<nav class="navbar">
    <div class="container">
        <a href="{{ route('fashion.index') }}" class="logo">OOTD</a>

        <ul class="nav-menu">
            <li><a href="{{ route('fashion.index') }}" class="nav-link">Home</a></li>
            <li><a href="{{ route('fashion.gallery') }}" class="nav-link">Gallery</a></li>
            <li><a href="{{ route('fashion.leaderboard') }}" class="nav-link">Leaderboard</a></li>

            @auth
                <li><a href="{{ route('fashion.upload') }}" class="nav-link">Submit Look</a></li>
                <li><a href="{{ route('profile') }}" class="nav-link">Profile</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer; font: inherit; color: #fff;">Log Out</button>
                    </form>
                </li>
            @else
                @if(Route::has('login'))
                    <li><a href="{{ route('login') }}" class="nav-link">Log in</a></li>
                @endif
                @if(Route::has('register'))
                    <li><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @endif
            @endauth
        </ul>

        <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
</nav>
