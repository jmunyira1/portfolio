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
    {{-- ── Projects ─────────────────────────────────────────────── --}}
    {{-- ── Projects ─────────────────────────────────────────────── --}}
    <section id="projects" class="py-5 border-top">

        <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">Projects</h2>

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

        <div class="row g-3" id="projects-grid">
            @forelse($projects as $project)
                @php
                    $isSoftware = $project['source'] === 'repo';
                    $type       = $isSoftware ? 'software' : 'technical';
                @endphp
                <div class="col-12 col-lg-6 col-xl-4 proj-item" data-type="{{ $type }}">

                    <div class="border rounded p-3 h-100 d-flex flex-column">

                        {{-- Cover image --}}
                        @if(!empty($project['cover']))
                            <a href="{{ route('projects.show', $project['slug']) }}"
                               class="d-block rounded overflow-hidden mb-3">
                                <img src="{{ $project['cover'] }}"
                                     alt="{{ $project['title'] }}"
                                     class="w-100 object-fit-cover rounded"
                                     style="height:160px">
                            </a>
                        @endif

                        {{-- Title + type badge --}}
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                            <a href="{{ route('projects.show', $project['slug']) }}"
                               class="fw-semibold text-body text-decoration-none fs-15 lh-sm">
                                {{ $project['title'] }}
                            </a>
                            <span class="badge bg-light text-muted border fw-normal fs-11 flex-shrink-0">
                        {{ $isSoftware ? 'Software' : 'Technical' }}
                    </span>
                        </div>

                        {{-- Summary --}}
                        <p class="text-muted fs-13 mb-2 flex-grow-1">
                            {{ Str::limit($project['summary'], 100) }}
                        </p>

                        {{-- Tech tags --}}
                        @if(!empty($project['tech']))
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @foreach(array_slice($project['tech'], 0, 4) as $tech)
                                    <span class="badge bg-light text-muted border fw-normal fs-11">{{ $tech }}</span>
                                @endforeach
                                @if(count($project['tech']) > 4)
                                    <span class="badge bg-light text-muted border fw-normal fs-11">
                        +{{ count($project['tech']) - 4 }}
                    </span>
                                @endif
                            </div>
                        @endif

                        {{-- Links --}}
                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('projects.show', $project['slug']) }}"
                               class="btn btn-dark btn-sm px-3 fs-12">
                                View project
                            </a>
                            @if(!empty($project['live_url']))
                                <a href="{{ $project['live_url'] }}" target="_blank"
                                   class="btn btn-outline-secondary btn-sm px-3 fs-12">
                                    Live <i class="ti ti-arrow-up-right fs-11"></i>
                                </a>
                            @endif
                            @if(!empty($project['github_url']))
                                <a href="{{ $project['github_url'] }}" target="_blank"
                                   class="btn btn-outline-secondary btn-sm px-3 fs-12">
                                    GitHub <i class="ti ti-arrow-up-right fs-11"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No projects yet.</p>
                </div>
            @endforelse
        </div>

    </section>
    @push('scripts')
        <script>
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
                    document.querySelectorAll('.proj-item').forEach(item => {
                        item.style.display =
                            (filter === 'all' || item.dataset.type === filter) ? '' : 'none';
                    });
                });
            });
        </script>
    @endpush
    {{-- ── Skills ───────────────────────────────────────────────── --}}
    {{-- ── Skills ───────────────────────────────────────────────── --}}
    <section id="skills" class="py-5 border-top">

        <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">Skills</h2>

        <div class="row g-3">
            @foreach($categories as $category)
                <div class="col-sm-6 col-xl-4">
                    <div class="border rounded p-3 h-100">

                        {{-- Category header --}}
                        <p class="fw-semibold fs-13 mb-3">
                            @if($category->icon)
                                <i class="{{ $category->icon }} me-1 text-muted"></i>
                            @endif
                            {{ $category->name }}
                        </p>

                        {{-- Skills list --}}
                        @foreach($category->skills as $skill)
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fs-12 d-flex align-items-center gap-1">
                            @if($skill->icon)
                                <i class="{{ $skill->icon }} text-muted"></i>
                            @endif
                            {{ $skill->name }}
                        </span>
                                    <span class="fs-11 text-muted">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="progress" style="height:2px">
                                    <div class="progress-bar bg-dark"
                                         role="progressbar"
                                         style="width:{{ $skill->proficiency }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endforeach
        </div>

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
