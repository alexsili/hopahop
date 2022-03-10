<nav class="navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container">
        <a href="{!! url('/') !!}" class="navbar-brand"><img src="/images/logo.png"
                                                             alt="{{ config('app.company_name') }}"
                                                             title="{{ config('app.company_name') }}"/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('/') !!}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('/songs') !!}">
                        Songs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('/drawings') !!}">
                        Drawings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('/sports') !!}">
                        Sports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('/shops') !!}">
                        Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('/about') !!}">
                        About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('/contact') !!}">
                        Contact
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if( !auth()->user()->isAdmin()  )
                        <li class="nav-item dropdown">
                            @if(auth()->user() && auth()->user()->hasVerifiedEmail())
                                <a class="nav-link " href="#" id="navbarDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell"></i>
                                </a>
                            @endif
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                            </ul>
                        </li>
                        @endif
                        </li>
                        <li class="nav-item">&nbsp;&nbsp;</li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle fas-grey" aria-hidden="true"></i>
                                {{Auth::user()->full_name}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if( auth()->user()->isAdmin())
                                    <li><a class="dropdown-item nav-link" href="/my-account">My Account</a></li>
                                    <li><a class="dropdown-item nav-link" href="/articles">Articles</a></li>
                                    <li><a class="dropdown-item nav-link" href="/personages">Characters</a></li>
                                    <li><a class="dropdown-item nav-link" href="/shop">Shop</a></li>
                                    <li><a class="dropdown-item nav-link" href="/messages">Messages</a></li>
                                    <li><a class="dropdown-item nav-link" href="/comments">Comments</a></li>
                                    <li><a class="dropdown-item nav-link" href="/users">Users</a></li>
                                @elseif(auth()->user()->isModerator())
                                    <li><a class="dropdown-item nav-link" href="/my-account">My Account</a></li>
                                    <li><a class="dropdown-item nav-link" href="/articles">Articles</a></li>
                                    <li><a class="dropdown-item nav-link" href="/personages">Characters</a></li>
                                    <li><a class="dropdown-item nav-link" href="/comments">Comments</a></li>
                                @endif
                                <li><a class="dropdown-item nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        </li>
                    @endguest
            </ul>
        </div>
    </div>
</nav>
</div>
