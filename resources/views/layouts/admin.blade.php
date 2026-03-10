<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title', 'Admin') | Portfolio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
<div class="wrapper">

    {{-- ── Sidebar ── --}}
    <div class="sidenav-menu">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <span class="logo-light">
                <span class="logo-lg"><img src="{{ asset('assets/images/logo.png') }}" alt="logo"></span>
                <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo"></span>
            </span>
            <span class="logo-dark">
                <span class="logo-lg"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo"></span>
                <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo"></span>
            </span>
        </a>

        <button class="button-sm-hover"><i class="ti ti-circle align-middle"></i></button>
        <button class="button-close-fullsidebar"><i class="ti ti-x align-middle"></i></button>

        <div data-simplebar>
            <ul class="side-nav">

                <li class="side-nav-title mt-2">Main</li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="side-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2">Background</li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.education.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.education.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-school"></i></span>
                        <span class="menu-text">Education</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.experiences.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                        <span class="menu-text">Experience</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.clients.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-building"></i></span>
                        <span class="menu-text">Clients</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2">Skills</li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.skill-categories.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.skill-categories.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-category"></i></span>
                        <span class="menu-text">Categories</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.skills.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-bulb"></i></span>
                        <span class="menu-text">Skills</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2">Portfolio</li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.projects.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-layout-grid"></i></span>
                        <span class="menu-text">Projects</span>
                    </a>
                </li>

                <li class="side-nav-title mt-2">Portfolio</li>

                <li class="side-nav-item">
                    <a href=""
                       class="side-nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-layout-grid"></i></span>
                        <span class="menu-text">Projects</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href=""
                       class="side-nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-bulb"></i></span>
                        <span class="menu-text">Skills</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href=""
                       class="side-nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-news"></i></span>
                        <span class="menu-text">Blog Posts</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href=""
                       class="side-nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-mail"></i></span>
                        <span class="menu-text">Messages</span>
                        {{-- unread badge --}}
                    </a>
                </li>

                <li class="side-nav-title mt-2">Settings</li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.settings.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-settings"></i></span>
                        <span class="menu-text">Site Settings</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2">Settings</li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.socials.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.socials.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-share"></i></span>
                        <span class="menu-text">Socials</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('admin.settings.index') }}"
                       class="side-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="ti ti-settings"></i></span>
                        <span class="menu-text">Settings</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    {{-- ── End Sidebar ── --}}


    {{-- ── Topbar ── --}}
    <header class="app-topbar">
        <div class="page-container topbar-menu">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="logo">
                    <span class="logo-light">
                        <span class="logo-lg"><img src="{{ asset('assets/images/logo.png') }}" alt="logo"></span>
                        <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo"></span>
                    </span>
                </a>
                <button class="sidenav-toggle-button btn btn-secondary btn-icon">
                    <i class="ti ti-menu-deep fs-24"></i>
                </button>
            </div>

            <div class="d-flex align-items-center gap-2">

                {{-- Light/Dark toggle --}}
                <div class="topbar-item d-none d-sm-flex">
                    <button class="topbar-link btn btn-outline-primary btn-icon" id="light-dark-mode" type="button">
                        <i class="ti ti-moon fs-22"></i>
                    </button>
                </div>

                {{-- User dropdown --}}
                <div class="topbar-item">
                    <div class="dropdown">
                        <a class="topbar-link btn btn-outline-primary dropdown-toggle drop-arrow-none"
                           data-bs-toggle="dropdown" data-bs-offset="0,22" type="button">
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                {{ auth()->user()->name }}
                            </span>
                            <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">{{ auth()->user()->name }}</h6>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-semibold">
                                    <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>
    {{-- ── End Topbar ── --}}


    {{-- ── Page Content ── --}}
    <div class="page-content">
        <div class="page-container">

            {{-- Page title / breadcrumb --}}
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2 mb-3">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold mb-0">@yield('page-title')</h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @yield('breadcrumb')
                    </ol>
                </div>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Main slot --}}
            @yield('content')

        </div>

        <footer class="footer">
            <div class="page-container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        {{ date('Y') }} &copy; Portfolio Admin
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end footer-links d-none d-md-block">
                            <a href="{{ route('home') }}" target="_blank">View Site</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    {{-- ── End Page Content ── --}}

</div>

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
