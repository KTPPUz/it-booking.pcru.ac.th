<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @include('cssjs.css')

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    {{-- AdminLTE --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/app.css')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"> --}}

    @vite('resources/js/app.js')


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @guest
            <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top"
                style="height: 7%; padding: 0 10px; background: linear-gradient(-45deg, rgba(147, 26, 222, 0.83) 0%, rgba(28, 206, 234, 0.82) 100%);">
                <div class="container-fluid">
                    <img src="{{ url('img/pcru.png') }}" height="60" class="d-inline-block align-top">
                    <a class="navbar-brand fw-bold text-white" href="{{ url('/') }}" style="margin-left:20px;">
                        IT-BOOKING</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav" style="margin-right:115px;">
                        <ul class="navbar-nav mb-1 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ url('/') }}">ปฏิทินการจอง</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('rooms.checkAvailable') }}">
                                    ตรวจสอบห้องว่าง
                                </a>
                            </li>
                            <!-- Dropdown Menu -->
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('rooms.show') }}">ห้องบริการ</a>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    รายงานข้อมูล
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item text-dark" href="{{ route('rooms.show') }}">ห้องบริการ</a>
                                    </li>
                                </ul>
                            </li> --}}
                        </ul>
                    </div>

                    <!-- Login Button -->
                    <div class="d-flex align-items-center">
                        <a class="btn btn-outline-light" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> ล็อกอิน
                        </a>
                    </div>
                    {{-- <div class="d-flex align-items-center">
                        <a class="btn btn-outline-light" href="{{ route('login.keycloak') }}">
                            <i class="fas fa-sign-in-alt"></i> ล็อกอิน
                        </a>
                    </div> --}}
                </div>
            </nav>

            <div style="margin-top: 55px; padding: 20px;">
                {{-- <section class="content">
                    <div class="container-fluid"> --}}
                @yield('content')
                {{-- @include('assettype.create') --}}
                {{-- </div>
                </section> --}}
            </div>

            <style>
                .logo-img {
                    max-width: 100%;
                    /* Ensures the image scales responsively */
                    height: auto;
                    /* Keeps the aspect ratio */
                    border-radius: 8px;
                    /* Rounded corners */
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    /* Subtle shadow */
                    margin: 20px auto;
                    /* Centers the image */
                    display: block;
                    /* Ensures the image is block-level for centering */
                }

                .navbar {
                    border-bottom: 2px solid #ffffff;
                    border-radius: 5px;
                }

                .btn-outline-light {
                    color: #ffffff;
                    border-color: #ffffff;
                }

                .btn-outline-light:hover {
                    background-color: #ffffff;
                    color: #17a2b8;
                    border-color: #ffffff;
                }

                .content {
                    background-color: #f8f9fa;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                }

                .nav-item.dropdown:hover .dropdown-menu {
                    display: block;
                    opacity: 1;
                    visibility: visible;
                    transition: opacity 0.3s ease;
                }

                .dropdown-menu {
                    display: none;
                    opacity: 0;
                    visibility: hidden;
                    position: absolute;
                    z-index: 1000;
                    top: 100%;
                    left: 0;
                    min-width: 10rem;
                    padding: 0.5rem 0;
                    background-color: #fff;
                    border: 1px solid rgba(0, 0, 0, 0.15);
                    border-radius: 0.25rem;
                    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
                }
            </style>
        @endguest


        @if (Auth::guard('web')->check())
            <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top"
                style="height: 7%; padding: 0 10px; background: linear-gradient(-45deg, rgba(147, 26, 222, 0.83) 0%, rgba(28, 206, 234, 0.82) 100%);">
                <div class="container-fluid">
                    <img src="{{ url('img/pcru.png') }}" height="60" class="d-inline-block align-top">
                    <a class="navbar-brand fw-bold text-white" href="{{ url('/') }}" style="margin-left:20px;">
                        IT-BOOKING</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav mb-1 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ url('/') }}">ปฏิทินการจอง</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('rooms.checkAvailable') }}">
                                    ตรวจสอบห้องว่าง
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('rooms.show') }}">
                                    ห้องบริการ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="{{ route('bookings') }}">
                                    ข้อมูลการจองห้อง
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    รายงานข้อมูล
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item text-dark"
                                            href="{{ route('br.bookingalluser') }}">รายการจองทั้งหมด</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <!-- Login Button -->
                    @guest
                        @if (Route::has('login'))
                            <a class="nav-link text-light" href="{{ route('login') }}" align="center"><i
                                    class="fas fa-sign-in-alt"></i> ล็อกอิน</a>
                        @endif
                    @else
                        <div class="dropdown" align="center" style="margin-right: 20px; position: relative;">
                            <a href="{{ route('userbooking.show') }}" class="nav-link text-dark position-relative">
                                <i class="fa fa-shopping-cart fa-1.5x text-primary"></i>
                                <span class="badge bg-danger rounded-circle position-absolute"
                                    style="top: -5px; right: -10px; font-size: 0.6rem;">
                                    @php
                                        $userId = Auth::guard('web')->user()->id;
                                        $cartItems = App\Models\UserBooking::where('user_id', $userId)->get();
                                        $count = $cartItems->count();
                                        echo $count;
                                    @endphp
                                </span>
                            </a>
                        </div>

                        <div class="dropdown" align="center">

                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::guard('web')->check())
                                    <i class="fas fa-user-alt"></i> &nbsp;{{ Auth::guard('web')->user()->name }}
                                @else
                                    <i class="fas fa-user-cog"></i> &nbsp;{{ Auth::guard('staff')->user()->name }}
                                @endif
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </nav>

            <div class="content"
                style="margin-top: 55px; padding: 20px; background-color: #f8f9fa; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">

                {{-- <section class="content">
                    <div class="container-fluid"> --}}
                @yield('content')
                {{-- @include('assettype.create') --}}
                {{-- </div>
                </section> --}}
            </div>

            <style>
                .logo-img {
                    max-width: 100%;
                    /* Ensures the image scales responsively */
                    height: auto;
                    /* Keeps the aspect ratio */
                    border-radius: 8px;
                    /* Rounded corners */
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    /* Subtle shadow */
                    margin: 20px auto;
                    /* Centers the image */
                    display: block;
                    /* Ensures the image is block-level for centering */
                }

                .navbar {
                    border-bottom: 2px solid #ffffff;
                    border-radius: 5px;
                }

                .btn-outline-light {
                    color: #ffffff;
                    border-color: #ffffff;
                }

                .btn-outline-light:hover {
                    background-color: #ffffff;
                    color: #17a2b8;
                    border-color: #ffffff;
                }

                .content {
                    background-color: #f8f9fa;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                }

                .nav-item.dropdown:hover .dropdown-menu {
                    display: block;
                    opacity: 1;
                    visibility: visible;
                    transition: opacity 0.3s ease;
                }
            </style>
        @endif







        @auth('staff')
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a class="nav-link" href="{{ route('staff.homestaff') }}">หน้าหลัก</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">คู่มือการใช้งาน</a>
                    </li>
                </ul>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <h3 class="brand-link" align="center">IT-BOOKING</h3>
                <div align="center">
                    @guest
                        @if (Route::has('login'))
                            <a class="nav-link text-light" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>
                                ล็อกอิน</a>
                        @endif
                    @else
                        <div class="dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-cog"></i> &nbsp;{{ optional(Auth::guard('staff')->user())->name }}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('staff-logout-form').submit();">
                                    Logout
                                </a>
                                <form id="staff-logout-form" action="{{ route('staff.logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
                <hr class="hr-white">
                <style>
                    .hr-white {
                        border-color: #4b545c;
                        border-style: solid;
                    }

                    /* .main-sidebar {
                                                                                            background-color: rgb(111, 41, 139);
                                                                                        } */

                    body {
                        height: 100vh;
                        overflow: hidden;
                    }
                </style>

                @include('layouts.sidebar')
            </aside>
            <br>
            <div class="content-wrapper">
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>
        @endauth

    </div>


    @include('cssjs.js')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script> --}}
    {{-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <!-- Bootstrap Select JS -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script> --}}
    {{-- <script src="{{ asset('plugins/select2-4.0.13/dist/js/select2.full.min.js') }}"></script> --}}
    @stack('scripts')
</body>

</html>
