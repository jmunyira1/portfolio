<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title', 'Your Name') | Full-Stack Developer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Full-stack developer portfolio')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

{{-- ── Navbar ── --}}
<nav class="navbar navbar-expand-lg sticky-top bg-white border-bottom">
    <div class="container">

        <a class="navbar-brand fw-bold fs-20" href="{{ route('home') }}">
            {{ \App\Models\Setting::get('name', 'Portfolio') }}
        </a>

        <div class="d-flex align-items-center gap-2 d-lg-none">
            {{-- Dark mode toggle (mobile) --}}
            <button class="btn btn-outline-secondary btn-sm" id="theme-toggle-mobile">
                <i class="ti ti-moon" id="theme-icon-mobile"></i>
            </button>
            <button class="navbar-toggler border-0" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <i class="ti ti-menu-2 fs-22"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#projects">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#skills">Skills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#experience">Experience</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                </li>

                @if(\App\Models\Setting::get('resume_path'))
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-dark btn-sm"
                           href="{{ asset(\App\Models\Setting::get('resume_path')) }}"
                           target="_blank">
                            <i class="ti ti-download me-1"></i> Resume
                        </a>
                    </li>
                @endif

                {{-- Dark mode toggle (desktop) --}}
                <li class="nav-item ms-lg-1 d-none d-lg-flex">
                    <button class="btn btn-outline-secondary btn-sm" id="theme-toggle-desktop">
                        <i class="ti ti-moon" id="theme-icon-desktop"></i>
                    </button>
                </li>
            </ul>
        </div>

    </div>
</nav>
{{-- ── End Navbar ── --}}


{{-- ── Page Content ── --}}
@yield('content')
{{-- ── End Page Content ── --}}


{{-- ── Footer ── --}}
<footer class="border-top py-4 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <span class="fw-semibold">{{ \App\Models\Setting::get('name', 'Portfolio') }}</span>
                <span class="text-muted ms-2 fs-13">Full-Stack Developer</span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                @foreach(\App\Models\Social::orderByDesc('is_primary')->get() as $social)
                    <a href="{{ $social->url }}"
                       class="text-muted me-3 text-decoration-none fs-13"
                       target="{{ str_starts_with($social->url, 'http') ? '_blank' : '_self' }}"
                       title="{{ $social->label }}">
                        @if($social->icon)
                            <i class="{{ $social->icon }}"></i>
                        @else
                            {{ $social->label }}
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        <hr class="my-3">
        <div class="text-center text-muted fs-12">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('name', 'Portfolio') }}. All rights reserved.
        </div>
    </div>
</footer>
{{-- ── End Footer ── --}}


<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
    // ── Dark mode ─────────────────────────────────────────────────
    const htmlEl = document.documentElement;
    const stored = localStorage.getItem('theme') || 'light';

    function applyTheme(theme) {
        htmlEl.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);

        // Update all toggle icons
        document.querySelectorAll('[id^="theme-icon"]').forEach(icon => {
            icon.className = theme === 'dark' ? 'ti ti-sun' : 'ti ti-moon';
        });
    }

    // Apply on load before render to avoid flash
    applyTheme(stored);

    // Wire up both toggles (mobile + desktop)
    document.querySelectorAll('[id^="theme-toggle"]').forEach(btn => {
        btn.addEventListener('click', () => {
            applyTheme(htmlEl.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
        });
    });

    // ── Smooth scroll for anchor links ────────────────────────────
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function (e) {
            const url = new URL(this.href, window.location.href);
            const isSamePage = url.pathname === window.location.pathname;
            const hash = url.hash;

            if (isSamePage && hash) {
                const target = document.querySelector(hash);
                if (target) {
                    e.preventDefault();
                    // Close mobile navbar if open
                    const navbar = document.getElementById('navbarNav');
                    if (navbar.classList.contains('show')) {
                        bootstrap.Collapse.getInstance(navbar)?.hide();
                    }
                    target.scrollIntoView({behavior: 'smooth', block: 'start'});
                }
            }
        });
    });

    // ── Active nav on scroll ──────────────────────────────────────
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('active', 'fw-semibold');
                    if (link.getAttribute('href')?.includes('#' + entry.target.id)) {
                        link.classList.add('active', 'fw-semibold');
                    }
                });
            }
        });
    }, {threshold: 0.4});

    sections.forEach(section => observer.observe(section));
</script>

@stack('scripts')

</body>
</html>
