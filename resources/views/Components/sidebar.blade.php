@props(['active'=>false ])
<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
      
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{request()->is('home') ? 'active': '' }}"  href="/home">
                        <svg class="bi" width="15" height="15"><use xlink:href="#house-fill"/></svg>
                        Home
                    </a>
                </li>
                @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{request()->is('free-day-request') ? 'active': '' }}" href="/free-day-request">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                            <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                        </svg>
                        Free Day Request
                    </a>
                </li>
                @endif

                @auth
                    @if(auth()->user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{request()->is('admin-view') ? 'active': '' }}" href="/admin-view">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                        Admin View
                    </a>
                </li>
                    @endif
                @endauth
                @auth
                    @if(auth()->user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{request()->is('admin-view-user') ? 'active': '' }}" href="/admin-view-user">
                        <svg class="bi" width="15" height="15"><use xlink:href="#people"/></svg>
                        Users
                    </a>
                </li>
                    @endif
                @endauth
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 {{request()->is('official-holiday') ? 'active': '' }}" href="/official-holiday">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-calendar-date" viewBox="0 0 16 16">
                                    <path d="M6.445 11.688V6.354h-.633A13 13 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                </svg>
                                Official Holiday
                            </a>
                        </li>
                    @endif
                @endauth

               @if(auth()->user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{request()->is('admin-statistics') ? 'active': '' }}" href="/admin-statistics">
                        <svg class="bi" width="15" height="15"><use xlink:href="#graph-up"/></svg>
                        Statistics
                    </a>
                </li>
                @elseif((Auth::check()))
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 active {{request()->is('statistics') ? 'active': ' ' }}" href="/statistics">
                            <svg class="bi" width="15" height="15"><use xlink:href="#graph-up"/></svg>
                            Statistics
                        </a>
                    </li>
                @endif

                @if(!Auth::check())
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="/login">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                            <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5"/>
                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                        Login
                    </a>
                </li>
                @endif
            </ul>

            <hr class="my-3">

            @if(Auth::check())
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="/logout">
                        <svg class="bi"width="15" height="15"><use xlink:href="#door-closed"/></svg>
                        Sign out
                    </a>
                </li>
            </ul>
            @endif
        </div>
    </div>
</div>
