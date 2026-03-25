<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('component.head')
    <title>@yield('title', 'Elshaddai LMS')</title>
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
                
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end" id="navbar">
                    <ul class="navbar-nav justify-content-end">
                        @auth
                        <li class="nav-item d-flex align-items-center pe-4 dropdown">
                            <a href="{{ route('profile.edit') }}" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-column text-end me-3 d-none d-sm-flex" style="line-height: 1.2;">
                                        <span class="text-sm font-weight-bold text-dark">{{ auth()->user()->nama_lengkap }}</span>
                                        <div class="d-flex align-items-center justify-content-end mt-1">
                                            @php
                                                $uStat = strtolower(auth()->user()->status_user);
                                                $dcCol = str_contains($uStat, 'dm') ? 'danger' : (str_contains($uStat, 'core') ? 'warning' : 'dark');
                                                $eqCol = 'secondary';
                                                switch(auth()->user()->equip_status) {
                                                    case 'Volunteer': $eqCol = 'primary'; break;
                                                    case 'Grow': $eqCol = 'info'; break;
                                                    case 'Plant': $eqCol = 'success'; break;
                                                }
                                                $c_sUser = auth()->user()->status_user == 'Disciple Maker' ? 'DM' : (auth()->user()->status_user == 'Core Team' ? 'Core' : auth()->user()->status_user);
                                            @endphp
                                            <span class="badge bg-gradient-{{ $dcCol }} px-2 py-1 me-1" style="font-size: 0.65rem;">{{ $c_sUser }}</span>
                                            <span class="badge bg-gradient-{{ $eqCol }} px-2 py-1" style="font-size: 0.65rem;">{{ auth()->user()->equip_status }}</span>
                                        </div>
                                    </div>
                                    <div class="avatar avatar-sm bg-gradient-dark rounded-circle shadow-sm d-flex align-items-center justify-content-center text-white">
                                        <i class="fas fa-user-astronaut"></i>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endauth
                        
                        <li class="nav-item d-flex align-items-center pe-2">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="javascript:;" onclick="document.getElementById('logout-form').submit();" class="nav-link text-body font-weight-bold px-0 d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt me-sm-1 text-danger"></i>
                                    <span class="d-sm-inline d-none text-danger">Logout</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        
        <!-- Compatibility for Both Breeze Component and Classic Yield -->
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
        
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
