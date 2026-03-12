@extends('layouts.app')

@section('title', $settings['name'] ?? 'Portfolio')
@section('meta_description', $settings['bio'] ?? '')

@section('content')

    {{-- ── Hero ────────────────────────────────────────────────── --}}
    <section id="hero" class="pb-5 mb-2">

        @if(!empty($settings['avatar']))
            <img src="{{ asset('storage/' . $settings['avatar']) }}"
                 alt="{{ $settings['name'] }}"
                 width="72" height="72"
                 class="rounded-circle object-fit-cover mb-4 d-block">
        @endif

        <h1 class="fw-bold mb-3 fs-2">
            {{ $settings['name'] ?? 'Munyira Joseph' }}
        </h1>

        @if(!empty($settings['bio']))
            <p class="text-muted mb-3 fs-15" style="max-width:520px">
                {{ $settings['bio'] }}
            </p>
        @endif

        @if(!empty($settings['location']))
            <p class="text-muted fs-13 mb-3">
                <i class="ti ti-map-pin me-1"></i>{{ $settings['location'] }}
            </p>
        @endif

        {{-- Primary contacts --}}
        <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
            @foreach($socials->where('is_primary', true) as $social)
                <a href="{{ $social->url }}"
                   class="text-body text-decoration-none fs-14 d-flex align-items-center gap-1">
                    @if($social->icon)
                        <i class="{{ $social->icon }}"></i>
                    @endif
                    {{ $social->value }}
                </a>
            @endforeach

            @if(!empty($settings['resume_path']))
                <a href="{{ asset($settings['resume_path']) }}" target="_blank"
                   class="text-body text-decoration-none fs-14">
                    Resume <i class="ti ti-arrow-up-right fs-12"></i>
                </a>
            @endif
        </div>

        {{-- Social icons --}}
        <div class="d-flex gap-3">
            @foreach($socials->where('is_primary', false) as $social)
                <a href="{{ $social->url }}" target="_blank"
                   title="{{ $social->label }}"
                   class="text-muted text-decoration-none fs-18 link-body-emphasis">
                    @if($social->icon)
                        <i class="{{ $social->icon }}"></i>
                    @else
                        <span class="fs-13">{{ $social->label }}</span>
                    @endif
                </a>
            @endforeach
        </div>

    </section>


    {{-- ── Projects ─────────────────────────────────────────────── --}}
    <section id="projects" class="py-5 border-top">

        <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">
            Projects
        </h2>

        {{-- Filter --}}
        <div class="d-flex gap-3 mb-4">
            <button class="proj-filter btn btn-link text-body fw-semibold p-0 text-decoration-underline shadow-none"
                    data-filter="all">All
            </button>
            <button class="proj-filter btn btn-link text-muted p-0 text-decoration-none shadow-none"
                    data-filter="software">Software
            </button>
            <button class="proj-filter btn btn-link text-muted p-0 text-decoration-none shadow-none"
                    data-filter="technical">Technical
            </button>
        </div>

        @forelse($projects as $project)
            <div class="proj-item mb-5" data-type="{{ $project->is_software ? 'software' : 'technical' }}">

                {{-- Cover image --}}
                @if($project->coverImage)
                    <a href="{{ route('projects.show', $project->slug) }}" class="d-block mb-3 rounded overflow-hidden">
                        <img src="{{ asset('storage/' . $project->coverImage->path) }}"
                             alt="{{ $project->title }}"
                             class="w-100 object-fit-cover rounded"
                             style="height:220px">
                    </a>
                @endif

                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div class="flex-grow-1">

                        <a href="{{ route('projects.show', $project->slug) }}"
                           class="fw-semibold text-body text-decoration-none fs-16">
                            {{ $project->title }}
                        </a>

                        <p class="text-muted fs-14 mt-1 mb-2">
                            {{ Str::limit($project->summary, 120) }}
                        </p>

                        @if($project->skills->count())
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                @foreach($project->skills->take(5) as $skill)
                                    <span class="badge bg-light text-muted border fw-normal fs-11">
                        {{ $skill->name }}
                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex gap-3 mt-2">
                            <a href="{{ route('projects.show', $project->slug) }}"
                               class="text-body text-decoration-none fs-13 fw-medium">
                                View project <i class="ti ti-arrow-right fs-12"></i>
                            </a>
                            @if($project->url)
                                <a href="{{ $project->url }}" target="_blank"
                                   class="text-muted text-decoration-none fs-13">
                                    Live <i class="ti ti-arrow-up-right fs-11"></i>
                                </a>
                            @endif
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank"
                                   class="text-muted text-decoration-none fs-13">
                                    GitHub <i class="ti ti-arrow-up-right fs-11"></i>
                                </a>
                            @endif
                        </div>

                    </div>

                    <span class="badge bg-light text-muted border fw-normal fs-11 flex-shrink-0">
                {{ $project->is_software ? 'Software' : 'Technical' }}
            </span>
                </div>

                @unless($loop->last)
                    <hr class="mt-4 mb-0">
                @endunless

            </div>
        @empty
            <p class="text-muted">No projects yet.</p>
        @endforelse

    </section>


    {{-- ── Skills ───────────────────────────────────────────────── --}}
    <section id="skills" class="py-5 border-top">

        <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">
            Skills
        </h2>

        @foreach($categories as $category)
            <div class="mb-4">
                <p class="fs-13 fw-semibold mb-3">
                    @if($category->icon)
                        <i class="{{ $category->icon }} me-1"></i>
                    @endif
                    {{ $category->name }}
                </p>

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
                        <div class="progress" style="height:3px">
                            <div class="progress-bar bg-dark"
                                 role="progressbar"
                                 style="width:{{ $skill->proficiency }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

    </section>


    {{-- ── Education & Experience ───────────────────────────────── --}}
    <section id="experience" class="py-5 border-top">

        <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">
            Education & Experience
        </h2>

        {{-- Education --}}
        <p class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-3">Education</p>

        @foreach($education as $edu)
            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
                <div>
                    <p class="fw-semibold mb-1">{{ $edu->degree }}</p>
                    <p class="text-muted fs-13 mb-1">
                        {{ $edu->institution }}
                        @if($edu->location)
                            · {{ $edu->location }}
                        @endif
                    </p>
                    @if($edu->grade)
                        <span class="badge bg-light text-muted border fw-normal fs-11">{{ $edu->grade }}</span>
                    @endif
                </div>
                <span class="text-muted fs-12 text-nowrap">
            {{ $edu->start_year }} — {{ $edu->is_current ? 'Present' : $edu->end_year }}
        </span>
            </div>
        @endforeach

        <hr class="my-4">

        {{-- Experience --}}
        <p class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-3">Experience</p>

        @foreach($experiences as $exp)
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-2">
                    <div>
                        <p class="fw-semibold mb-0">{{ $exp->title }}</p>
                        <p class="text-muted fs-13 mb-0">{{ $exp->client->name }}</p>
                    </div>
                    <span class="text-muted fs-12 text-nowrap">
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
        @endforeach

    </section>


    {{-- ── Contact ───────────────────────────────────────────────── --}}
    <section id="contact" class="py-5 border-top">

        <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">
            Contact
        </h2>

        <p class="text-muted fs-14 mb-4" style="max-width:480px">
            Have a project in mind or just want to say hi? Fill in the form or reach me at
            <a href="mailto:{{ $settings['contact_email'] ?? '' }}"
               class="text-body text-decoration-none fw-medium">
                {{ $settings['contact_email'] ?? '' }}
            </a>.
        </p>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fs-13" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}" class="row g-3">
            @csrf

            <div class="col-md-6">
                <label class="form-label fs-13 fw-medium">Name <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       class="form-control form-control-sm @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Your name">
                @error('name')
                <div class="invalid-feedback fs-12">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-medium">Email <span class="text-danger">*</span></label>
                <input type="email" name="email"
                       class="form-control form-control-sm @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="your@email.com">
                @error('email')
                <div class="invalid-feedback fs-12">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fs-13 fw-medium">Subject</label>
                <input type="text" name="subject"
                       class="form-control form-control-sm"
                       value="{{ old('subject') }}" placeholder="What's this about?">
            </div>

            <div class="col-12">
                <label class="form-label fs-13 fw-medium">Message <span class="text-danger">*</span></label>
                <textarea name="message" rows="5"
                          class="form-control form-control-sm @error('message') is-invalid @enderror"
                          placeholder="Tell me about your project...">{{ old('message') }}</textarea>
                @error('message')
                <div class="invalid-feedback fs-12">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-dark btn-sm px-4">
                    Send message <i class="ti ti-arrow-right ms-1 fs-13"></i>
                </button>
            </div>

        </form>

    </section>

@endsection

@push('scripts')
    <script>
        // Project filter
        const filterBtns = document.querySelectorAll('.proj-filter');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                filterBtns.forEach(b => {
                    b.classList.remove('text-body', 'fw-semibold', 'text-decoration-underline');
                    b.classList.add('text-muted');
                });
                this.classList.add('text-body', 'fw-semibold', 'text-decoration-underline');
                this.classList.remove('text-muted');

                const filter = this.dataset.filter;
                const items = document.querySelectorAll('.proj-item');

                items.forEach(item => {
                    item.style.display =
                        (filter === 'all' || item.dataset.type === filter) ? '' : 'none';
                });

                // Show divider only before last visible item
                const visible = [...items].filter(i => i.style.display !== 'none');
                items.forEach(item => {
                    const hr = item.querySelector('hr');
                    if (hr) hr.style.display = 'none';
                });
                visible.slice(0, -1).forEach(item => {
                    const hr = item.querySelector('hr');
                    if (hr) hr.style.display = '';
                });
            });
        });
    </script>
@endpush
