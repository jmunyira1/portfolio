@extends('layouts.app')

@section('title', $settings['name'] ?? 'Portfolio')
@section('meta_description', $settings['bio'] ?? '')

@section('content')

    {{-- ── Hero ────────────────────────────────────────────────── --}}
    <section id="hero" class="py-5 border-bottom">
        <div class="container py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">

                    @if(!empty($settings['avatar']))
                        <img src="{{ asset('storage/' . $settings['avatar']) }}"
                             alt="{{ $settings['name'] }}"
                             class="rounded-circle mb-3"
                             width="80" height="80"
                             style="object-fit:cover">
                    @endif

                    <h1 class="fw-bold mb-2 fs-1">
                        {{ $settings['name'] ?? 'Your Name' }}
                    </h1>

                    @if(!empty($settings['tagline']))
                        <p class="text-muted fs-5 mb-3">{{ $settings['tagline'] }}</p>
                    @endif

                    @if(!empty($settings['bio']))
                        <p class="mb-4" style="max-width:600px">{{ $settings['bio'] }}</p>
                    @endif

                    {{-- Primary socials --}}
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach($socials->where('is_primary', true) as $social)
                            <a href="{{ $social->url }}" class="btn btn-dark btn-sm">
                                @if($social->icon)
                                    <i class="{{ $social->icon }} me-1"></i>
                                @endif
                                {{ $social->value }}
                            </a>
                        @endforeach

                        @if(!empty($settings['resume_path']))
                            <a href="{{ asset($settings['resume_path']) }}"
                               class="btn btn-outline-dark btn-sm" target="_blank">
                                <i class="ti ti-download me-1"></i> Resume
                            </a>
                        @endif
                    </div>

                    {{-- Other socials --}}
                    <div class="d-flex gap-3">
                        @foreach($socials->where('is_primary', false) as $social)
                            <a href="{{ $social->url }}" target="_blank"
                               class="text-muted text-decoration-none" title="{{ $social->label }}">
                                @if($social->icon)
                                    <i class="{{ $social->icon }} fs-20"></i>
                                @else
                                    {{ $social->label }}
                                @endif
                            </a>
                        @endforeach
                    </div>

                </div>

                @if(!empty($settings['location']))
                    <div class="col-lg-4 text-lg-end">
                <span class="text-muted fs-13">
                    <i class="ti ti-map-pin me-1"></i>{{ $settings['location'] }}
                </span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Projects ─────────────────────────────────────────────── --}}
    <section id="projects" class="py-5 border-bottom">
        <div class="container py-3">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fw-bold mb-0">Projects</h2>
                {{-- Filter tabs --}}
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-dark project-filter active" data-filter="all">All</button>
                    <button class="btn btn-sm btn-outline-secondary project-filter" data-filter="software">Software
                    </button>
                    <button class="btn btn-sm btn-outline-secondary project-filter" data-filter="technical">Technical
                    </button>
                </div>
            </div>

            <div class="row g-4" id="projects-grid">
                @forelse($projects as $project)
                    <div class="col-md-6 col-lg-4 project-item"
                         data-type="{{ $project->is_software ? 'software' : 'technical' }}">
                        <div class="card h-100 border-0 shadow-sm">

                            {{-- Cover image --}}
                            @if($project->coverImage)
                                <div style="height:200px;overflow:hidden">
                                    <img src="{{ asset('storage/' . $project->coverImage->path) }}"
                                         alt="{{ $project->title }}"
                                         class="card-img-top w-100 h-100"
                                         style="object-fit:cover">
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height:200px">
                                    <i class="ti ti-photo text-muted fs-32"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                    <h5 class="card-title fw-semibold mb-0">{{ $project->title }}</h5>
                                    @if($project->is_software)
                                        <span class="badge bg-primary-subtle text-primary flex-shrink-0">Software</span>
                                    @else
                                        <span
                                            class="badge bg-warning-subtle text-warning flex-shrink-0">Technical</span>
                                    @endif
                                </div>

                                <p class="card-text text-muted fs-13 flex-grow-1">
                                    {{ Str::limit($project->summary, 100) }}
                                </p>

                                {{-- Skills --}}
                                @if($project->skills->count())
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        @foreach($project->skills->take(4) as $skill)
                                            <span
                                                class="badge bg-light text-dark border fs-11">{{ $skill->name }}</span>
                                        @endforeach
                                        @if($project->skills->count() > 4)
                                            <span
                                                class="badge bg-light text-muted border fs-11">+{{ $project->skills->count() - 4 }}</span>
                                        @endif
                                    </div>
                                @endif

                                {{-- Actions --}}
                                <div class="d-flex gap-2 mt-auto">
                                    <a href="{{ route('projects.show', $project->slug) }}"
                                       class="btn btn-sm btn-dark">
                                        View Project
                                    </a>
                                    @if($project->url)
                                        <a href="{{ $project->url }}" target="_blank"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-external-link"></i>
                                        </a>
                                    @endif
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-brand-github"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No projects yet.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    {{-- ── Skills ───────────────────────────────────────────────── --}}
    <section id="skills" class="py-5 border-bottom">
        <div class="container py-3">
            <h2 class="fw-bold mb-4">Skills</h2>

            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} me-2 text-primary"></i>
                                    @endif
                                    {{ $category->name }}
                                </h6>
                                @foreach($category->skills as $skill)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                <span class="fs-13">
                                    @if($skill->icon)
                                        <i class="{{ $skill->icon }} me-1"></i>
                                    @endif
                                    {{ $skill->name }}
                                </span>
                                            <span class="fs-12 text-muted">{{ $skill->proficiency }}%</span>
                                        </div>
                                        <div class="progress" style="height:5px">
                                            <div class="progress-bar bg-primary"
                                                 style="width:{{ $skill->proficiency }}%"
                                                 role="progressbar"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ── Education & Experience ───────────────────────────────── --}}
    <section id="experience" class="py-5 border-bottom">
        <div class="container py-3">
            <h2 class="fw-bold mb-4">Education & Experience</h2>

            <div class="row g-4">

                {{-- Education --}}
                <div class="col-lg-5">
                    <h5 class="fw-semibold mb-3">
                        <i class="ti ti-school me-2 text-primary"></i>Education
                    </h5>
                    @foreach($education as $edu)
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ $edu->degree }}</h6>
                                        <p class="text-muted mb-1 fs-13">{{ $edu->institution }}</p>
                                        @if($edu->grade)
                                            <span
                                                class="badge bg-success-subtle text-success fs-11">{{ $edu->grade }}</span>
                                        @endif
                                    </div>
                                    <span class="text-muted fs-12 text-nowrap ms-2">
                                {{ $edu->start_year }} — {{ $edu->is_current ? 'Present' : $edu->end_year }}
                            </span>
                                </div>
                                @if($edu->location)
                                    <p class="text-muted fs-12 mb-0 mt-2">
                                        <i class="ti ti-map-pin me-1"></i>{{ $edu->location }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Experience --}}
                <div class="col-lg-7">
                    <h5 class="fw-semibold mb-3">
                        <i class="ti ti-briefcase me-2 text-primary"></i>Experience
                    </h5>
                    @foreach($experiences as $exp)
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-semibold mb-0">{{ $exp->title }}</h6>
                                        <p class="text-muted fs-13 mb-0">{{ $exp->client->name }}</p>
                                    </div>
                                    <span class="text-muted fs-12 text-nowrap ms-2">
                                {{ $exp->start_date->format('M Y') }} —
                                {{ $exp->is_current ? 'Present' : $exp->end_date?->format('M Y') }}
                            </span>
                                </div>
                                <ul class="mb-0 ps-3">
                                    @foreach($exp->responsibilities as $resp)
                                        <li class="text-muted fs-13 mb-1">{{ $resp }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    {{-- ── Contact ───────────────────────────────────────────────── --}}
    <section id="contact" class="py-5">
        <div class="container py-3">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    <h2 class="fw-bold mb-2">Get in Touch</h2>
                    <p class="text-muted mb-4">
                        Have a project in mind or just want to say hi? Fill out the form below.
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('contact.send') }}">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}"
                                               placeholder="Your name">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}"
                                               placeholder="your@email.com">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject"
                                               class="form-control"
                                               value="{{ old('subject') }}"
                                               placeholder="What's this about?">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Message <span class="text-danger">*</span></label>
                                        <textarea name="message" rows="5"
                                                  class="form-control @error('message') is-invalid @enderror"
                                                  placeholder="Tell me about your project or inquiry...">{{ old('message') }}</textarea>
                                        @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-dark">
                                            <i class="ti ti-send me-1"></i> Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Direct contact --}}
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        @foreach($socials->where('is_primary', true) as $social)
                            <a href="{{ $social->url }}" class="text-muted text-decoration-none fs-13">
                                @if($social->icon)
                                    <i class="{{ $social->icon }} me-1"></i>
                                @endif
                                {{ $social->value }}
                            </a>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // Project filter
        document.querySelectorAll('.project-filter').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.project-filter').forEach(b => {
                    b.classList.remove('active', 'btn-dark');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.add('active', 'btn-dark');
                this.classList.remove('btn-outline-secondary');

                const filter = this.dataset.filter;
                document.querySelectorAll('.project-item').forEach(item => {
                    item.style.display = (filter === 'all' || item.dataset.type === filter) ? '' : 'none';
                });
            });
        });
    </script>
@endpush
