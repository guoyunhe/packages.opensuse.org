<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://static.opensuse.org/favicon.ico">
    <link rel="icon" href="https://static.opensuse.org/favicon-32.png" sizes="32x32">
    <link rel="icon" href="https://static.opensuse.org/favicon-48.png" sizes="48x48">
    <link rel="icon" href="https://static.opensuse.org/favicon-64.png" sizes="64x64">
    <link rel="icon" href="https://static.opensuse.org/favicon-96.png" sizes="96x96">
    <link rel="icon" href="https://static.opensuse.org/favicon-144.png" sizes="144x144">
    <link rel="icon" href="https://static.opensuse.org/favicon-192.png" sizes="192x192">

    <!-- apple-touch-icon -->
    <link rel="apple-touch-icon" href="https://static.opensuse.org/favicon-144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="https://static.opensuse.org/favicon-192.png" sizes="192x192">
    <link rel="mask-icon" href="https://static.opensuse.org/mask-icon.svg" color="#73ba25">

    <!-- Chameleon Theme -->
    <link href="https://static.opensuse.org/chameleon-3.0/dist/css/chameleon.css" rel="stylesheet"/>
    <script src="https://static.opensuse.org/chameleon-3.0/dist/js/jquery.slim.js" defer></script>
    <script src="https://static.opensuse.org/chameleon-3.0/dist/js/bootstrap.bundle.js" defer></script>
    <script src="https://static.opensuse.org/chameleon-3.0/dist/js/chameleon.js" defer></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Data -->
    <script>
        var distros = {!! json_encode(config('obs.distros')) !!};
        var archs = {!! json_encode(config('obs.archs')) !!};
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-md">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ config('app.logo') }}" class="d-inline-block align-top" alt="🦎" title="openSUSE" width="30" height="30">
            <span class="navbar-title"><span>{{ config('app.name') }}</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse">
            <svg width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
            </svg>
        </button>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <!-- Left Side Of Navbar -->
            <form class="form-inline mr-auto" action="/search">
                <select id="distro-select" name="distro" class="custom-select mr-md-2">
                    @foreach (config('obs.distros') as $value => $name)
                        <option value="{{ $value }}" {{ Cookie::get('distro') === $value ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <select id="arch-select" name="arch" class="custom-select mr-md-2">
                    @foreach (config('obs.archs') as $value)
                        <option value="{{ $value }}" {{ Cookie::get('arch') === $value ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <div class="input-group">
                    <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Search packages..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto d-none">
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
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
        <button class="navbar-toggler megamenu-toggler" type="button" data-toggle="collapse" data-target="#megamenu" aria-expanded="true">
            <svg class="bi bi-grid" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
            </svg>
        </button>
    </nav>
    <div id="megamenu" class="megamenu collapse"></div>

    <main>
        @yield('content')
    </main>
</body>
</html>
