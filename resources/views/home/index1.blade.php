<section id="projects" class="py-5 border-top">

    <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">Projects</h2>

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

                    @if(!empty($project['cover']))
                        <a href="{{ route('projects.show', $project['slug']) }}"
                           class="d-block rounded overflow-hidden mb-3">
                            <img src="{{ $project['cover'] }}"
                                 alt="{{ $project['title'] }}"
                                 class="w-100 object-fit-cover rounded"
                                 style="height:160px">
                        </a>
                    @endif

                    <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                        <a href="{{ route('projects.show', $project['slug']) }}"
                           class="fw-semibold text-body text-decoration-none fs-15 lh-sm">
                            {{ $project['title'] }}
                        </a>
                        <span class="badge bg-light text-muted border fw-normal fs-11 flex-shrink-0">
                        {{ $isSoftware ? 'Software' : 'Technical' }}
                    </span>
                    </div>

                    <p class="text-muted fs-13 mb-2 flex-grow-1">
                        {{ Str::limit($project['summary'], 100) }}
                    </p>

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
{{-- ── Experience ───────────────────────────────────────────── --}}
<section id="experience" class="py-5 border-top">

    <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">Experience</h2>

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

{{-- ── Education ────────────────────────────────────────────── --}}
<section id="education" class="py-5 border-top">

    <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">Education</h2>

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

</section>


{{-- ── Contact ───────────────────────────────────────────────── --}}
<section id="contact" class="py-5 border-top">

    <h2 class="fs-11 fw-semibold text-uppercase text-muted letter-spacing-1 mb-4">Contact</h2>

    <p class="text-muted fs-14 mb-4">
        Have a project in mind or just want to say hi? Fill in the form or reach me at
        <a href="mailto:{{ $settings['contact_email'] ?? '' }}"
           class="text-body text-decoration-none fw-medium">
            {{ $settings['contact_email'] ?? '' }}
        </a>.
    </p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-13">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form class="row g-3">

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
