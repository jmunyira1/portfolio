<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title', 'Munyira Joseph')</title>
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
<nav class="navbar navbar-expand-md py-3 border-bottom mb-5">
    <div class="container-lg">

        <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold p-0" href="{{ route('home') }}">
            @php $avatar = \App\Models\Setting::get('avatar'); @endphp
            @if($avatar)
                <img src="{{ asset('storage/' . $avatar) }}"
                     alt="{{ \App\Models\Setting::get('name') }}"
                     width="32" height="32"
                     class="rounded-circle object-fit-cover">
            @endif
            {{ \App\Models\Setting::get('name', 'Portfolio') }}
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="ti ti-menu-2 fs-20"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-md-center gap-md-1">

                <li class="nav-item">
                    <a class="nav-link text-muted py-1" href="{{ route('home') }}#skills">Skills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted py-1" href="{{ route('home') }}#projects">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted py-1" href="{{ route('home') }}#experience">Experience</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted py-1" href="{{ route('home') }}#contact">Contact</a>
                </li>
                @if(\App\Models\Setting::get('resume_path'))
                    <li class="nav-item">
                        <a class="nav-link text-muted py-1"
                           href="{{ asset(\App\Models\Setting::get('resume_path')) }}"
                           target="_blank">
                            Resume <i class="ti ti-arrow-up-right fs-12"></i>
                        </a>
                    </li>
                @endif
                <li class="nav-item ms-md-2">
                    <button class="btn btn-link text-muted p-0 shadow-none" id="theme-toggle">
                        <i class="ti ti-moon fs-18" id="theme-icon"></i>
                    </button>
                </li>
            </ul>
        </div>

    </div>
</nav>
{{-- ── End Navbar ── --}}


{{-- ── Page Content ── --}}
<div class="container-lg pb-5">
    @yield('content')
</div>
{{-- ── End Page Content ── --}}


{{-- ── Footer ── --}}
<footer class="border-top py-4 mt-4">
    <div class="container-lg d-flex align-items-center justify-content-between flex-wrap gap-3">
            <span class="text-muted fs-13">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::get('name', 'Portfolio') }}
            </span>
        <div class="d-flex gap-3">
            @foreach(\App\Models\Social::orderByDesc('is_primary')->get() as $social)
                <a href="{{ $social->url }}"
                   target="{{ str_starts_with($social->url, 'http') ? '_blank' : '_self' }}"
                   title="{{ $social->label }}"
                   class="text-muted text-decoration-none fs-18">
                    @if($social->icon)
                        <i class="{{ $social->icon }}"></i>
                    @else
                        <span class="fs-13">{{ $social->label }}</span>
                    @endif
                </a>
            @endforeach
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
        document.getElementById('theme-icon').className =
            theme === 'dark' ? 'ti ti-sun fs-18' : 'ti ti-moon fs-18';
    }

    applyTheme(stored);

    document.getElementById('theme-toggle').addEventListener('click', () => {
        applyTheme(htmlEl.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
    });

    // ── Smooth scroll ─────────────────────────────────────────────
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function (e) {
            const url = new URL(this.href, window.location.href);
            const isSamePage = url.pathname === window.location.pathname;
            const hash = url.hash;
            if (isSamePage && hash) {
                const target = document.querySelector(hash);
                if (target) {
                    e.preventDefault();
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

    sections.forEach(section => {
        new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => {
                        link.classList.remove('fw-semibold');
                        link.classList.add('text-muted');
                        if (link.getAttribute('href')?.includes('#' + entry.target.id)) {
                            link.classList.add('fw-semibold');
                            link.classList.remove('text-muted');
                        }
                    });
                }
            });
        }, {threshold: 0.4}).observe(section);
    });
</script>

@stack('scripts')

</body>
</html>
