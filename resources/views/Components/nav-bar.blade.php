<nav class="navbar sticky-top navbar-expand-lg" style="background-color: #e3f2fd" data-bs-theme="light">
    <div class="container-fluid">
        <a class="navbar-brand" href='/home'>Vacation Vault</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{request()->is('home') ? 'active': '' }}"  href="/home">
                        <svg class="bi" width="15" height="15"><use xlink:href="#house-fill"/></svg>
                        Home
                    </a>
                </li>
                @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{request()->is('free-day-request') ? 'active': '' }}" href="/free-day-request">
                            Free Day Request
                        </a>
                    </li>
                @endif

                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{request()->is('admin-view') ? 'active': '' }}" href="/admin-view">
                                Admin View
                            </a>
                        </li>
                    @endif
                @endauth
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{request()->is('admin-view-user') ? 'active': '' }}" href="/admin-view-user">
                                Users
                            </a>
                        </li>
                    @endif
                @endauth
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{request()->is('official-holiday') ? 'active': '' }}" href="/official-holiday">
                                Official Holiday
                            </a>
                        </li>
                    @endif
                @endauth

                @if(auth()->user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{request()->is('admin-statistics') ? 'active': '' }}" href="/admin-statistics">
                            Statistics
                        </a>
                    </li>
                @elseif((Auth::check()))
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 active {{request()->is('statistics') ? 'active': ' ' }}" href="/statistics">
                            Statistics
                        </a>
                    </li>
                @endif

                @if(!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="/login">
                            Login
                        </a>
                    </li>
                @endif
            </ul>
            <div class="flex-shrink-0 dropstart px-2" >
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small shadow" style="">
                    <li><a class="dropdown-item" href="{{ url('/user-profile/' . Auth::id()) }}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href='/logout'>Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
