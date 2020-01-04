        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <h3 class="text-success font-italic">
                    {{ config('app.name', 'Meeting App') }}
                </h3>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse offset-sm-1" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    <!-- perm -->
                    @if (Auth::user()->permission != 0)
                        <li class="nav-item {{ Request::is('createmeeting') ? ' active ' : '' }}">
                            <a class="nav-link" href=" {{ route('createMeeting') }} ">Create Meeting</a>
                        </li>
                    @endif
                        <li class="nav-item {{ Request::is('nextmeetings') ? ' active ' : '' }}">
                            <a class="nav-link" href=" {{ route('nextMeetings') }} ">Next Meetings</a>
                        </li>
                    @if (Auth::user()->permission != 0)
                        <li class="nav-item {{ Request::is('reportarea/*') || Request::is('reportarea') ? ' active ' : '' }}">
                            <a class="nav-link" href=" {{ route('reportArea') }} ">Report Area</a>
                        </li>
                    @endif
                    @if (Auth::user()->permission == 2)
                        <li class="nav-item {{ Request::is('adminarea') ? ' active ' : '' }}">
                            <a class="nav-link" href=" {{ route('adminArea') }} ">Admin Area</a>
                        </li>
                    @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else <!-- This dropdown menu doesn't work-->
                            
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

