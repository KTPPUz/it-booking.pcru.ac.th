<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Additional CSS/JS -->
    @include('cssjs.css')
    @include('cssjs.js')

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Timepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">

    <!-- Lightbox -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

</head>

<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-warning shadow-sm" style="height:80px">
            <div class="container-fluid" style="width:80%">
                @if (Auth::guard('staff')->check())
                <a class="navbar-brand" href="{{ route('staff.homestaff') }}">
                    IT-BOOKING (Staff)
                </a>
                @elseif (Auth::guard('web')->check())
                <a class="navbar-brand" href="{{ url('/') }}">
                    IT-BOOKING (User)
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    IT-BOOKING (Guest)
                </a>
                @endif

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto">
                        @if (Auth::guard('web')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bookings') }}" style="color:black;">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rooms.show') }}" style="color:black;">Room</a>
                        </li>
                        @endif
                        @if (Auth::guard('staff')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rooms') }}" style="color:black;">Room</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff.index') }}" style="color:black;">Staff</a>
                        </li>
                        @endif
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rooms.show') }}" style="color:black;">Room</a>
                        </li>
                        @endguest
                    </ul>

                    <ul class="navbar-nav ms-auto">
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
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if (Auth::guard('web')->check())
                                {{ Auth::guard('web')->user()->name }} (User)
                                @else
                                {{ Auth::guard('staff')->user()->name }} (Staff)
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if (Auth::guard('web')->check())
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                @endif
                                @if (Auth::guard('staff')->check())
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('staff-logout-form').submit();">
                                    Logout
                                </a>
                                <form id="staff-logout-form" action="{{ route('staff.logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                                @endif
                            </div>
                        </li>
                        @endguest
                    </ul>

                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>