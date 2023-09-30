<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light nav-background shadow-sm fixed z-3">

            <div class="container">
                <a class="navbar-brand d-flex align-items-center transition-logo"
                    href="{{ url('http://localhost:5174/') }}">
                    <div class="logo-laravel">
                        <h2 class="logo p-4 rounded-5 shadow-lg"><i class="fa-solid fa-earth-europe"></i>BoolBnB</h2>
                    </div>
                    {{-- config('app.name', 'Laravel') --}}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link fs-4 fw-semibold link-hover-header px-3 py-2 rounded-5"
                                href="{{ url('admin/apartments') }}">{{ __('Home') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link fs-4 fw-semibold link-hover-header px-3 py-2 rounded-5"
                                    href="{{ route('login') }}">{{ __('Accedi') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link fs-4 fw-semibold link-hover-header px-3 py-2 rounded-5"
                                        href="{{ route('register') }}">{{ __('Registrati') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown"
                                    class="nav-link dropdown-toggle fs-4 fw-semibold link-hover-header px-3 py-2 rounded-5"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right border-none" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item drop-down" href="{{ url('profile') }}">{{ __('Account') }}</a>
                                    <a class="dropdown-item drop-down" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="sidebar background-color px-0">
                    <!-- Sidebar -->
                    <nav id="sidebarMenu" class="side-bar">
                        <div class="mt-4">
                            <a href="{{ route('admin.apartments.index') }}"
                                class="list-group-item py-2 ripple {{ Route::currentRouteName() === 'admin.apartments.index' ? 'selected' : '' }} select">
                                <div class="text-container d-flex align-items-center">
                                    <i class="fa-solid fa-house-user ms-3"></i>
                                    <h4 class="ms-2">Appartamenti</h4>
                                </div>
                            </a>
                            <a href="{{ route('admin.sponsors.index') }}"
                                class="list-group-item list-group-item-action py-2 ripple {{ Route::currentRouteName() === 'admin.sponsors.index' ? 'selected' : '' }} select">
                                <div class="text-container d-flex align-items-center">
                                    <i class="fa-regular fa-lightbulb ms-3"></i>
                                    <h4 class="ms-3">Sponsor</h4>
                                </div>
                            </a>
                            <a href=""
                                class="list-group-item list-group-item-action py-2 ripple {{ Route::currentRouteName() === '' ? 'selected' : '' }} select">
                                <div class="text-container d-flex align-items-center">
                                    <i class="fa-solid fa-diagram-project ms-3"></i>
                                    <h4 class="ms-3">Statistiche</h4>
                                </div>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="main-width">
                    <div class="">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
{{-- NEL CASO SI VOLESSE IL FOOTER E PRONTO --}}
{{-- <footer>
    @include('admin.partials.footer')
</footer> --}}

</html>
