<!doctype html>
<html lang="en">
<head>
    @include('component.head')
    <title>@yield('title')</title>
    @stack('styles')
</head>
<body class="g-sidenav-show bg-gray-100">
    @include('component.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar with hamburger menu for mobile -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                            @yield('title', 'Dashboard')
                        </li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">@yield('title', 'Dashboard')</h6>
                </nav>
                <div class="ms-auto d-xl-none">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        @yield('content')
        @include('component.footer')
    </main>
    @include('component.side-nav')

    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
    @stack('scripts')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/soft-ui-dashboard.js?v=1.0.3') }}"></script>
</body>
</html>
