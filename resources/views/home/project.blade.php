@extends('layouts.app')

@section('title', $project->title)
@section('meta_description', $project->summary)

@section('content')
    <div class="container py-5">

        {{-- Back --}}
        <a href="{{ route('home') }}#projects" class="btn btn-outline-secondary btn-sm mb-4">
            <i class="ti ti-arrow-left me-1"></i> Back to Projects
        </a>

        <div class="row g-5">

            {{-- Left — images carousel --}}
            <div class="col-lg-7">
                @if($project->images->count())
                    <div id="projectCarousel" class="carousel slide rounded overflow-hidden shadow-sm"
                         data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($project->images as $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                         class="d-block w-100"
                                         alt="{{ $image->caption ?? $project->title }}"
                                         style="height:400px;object-fit:cover">
                                    @if($image->caption)
                                        <div class="carousel-caption d-none d-md-block">
                                            <p class="mb-0 fs-13">{{ $image->caption }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if($project->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#projectCarousel"
                                    data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#projectCarousel"
                                    data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            <div class="carousel-indicators position-relative mt-2">
                                @foreach($project->images as $image)
                                    <button type="button" data-bs-target="#projectCarousel"
                                            data-bs-slide-to="{{ $loop->index }}"
                                            class="{{ $loop->first ? 'active' : '' }}"
                                            style="width:60px;height:40px;opacity:0.6">
                                        <img src="{{ asset('storage/' . $image->path) }}"
                                             class="w-100 h-100 rounded" style="object-fit:cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm"
                         style="height:400px">
                        <i class="ti ti-photo text-muted fs-48"></i>
                    </div>
                @endif
            </div>

            {{-- Right — details --}}
            <div class="col-lg-5">

                <div class="d-flex gap-2 mb-3">
                    @if($project->is_software)
                        <span class="badge bg-primary-subtle text-primary">Software</span>
                    @else
                        <span class="badge bg-warning-subtle text-warning">Technical</span>
                    @endif
                    @if($project->category)
                        <span class="badge bg-light text-dark border">{{ $project->category->name }}</span>
                    @endif
                    @if($project->client)
                        <span class="badge bg-light text-dark border">{{ $project->client->name }}</span>
                    @endif
                </div>

                <h1 class="fw-bold mb-3">{{ $project->title }}</h1>

                <p class="text-muted">{{ $project->description ?? $project->summary }}</p>

                {{-- Links --}}
                <div class="d-flex gap-2 my-4">
                    @if($project->url)
                        <a href="{{ $project->url }}" target="_blank" class="btn btn-dark btn-sm">
                            <i class="ti ti-external-link me-1"></i> Live Site
                        </a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-dark btn-sm">
                            <i class="ti ti-brand-github me-1"></i> GitHub
                        </a>
                    @endif
                </div>

                {{-- Key features --}}
                @if(!empty($project->key_features))
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Key Features</h6>
                        <ul class="list-unstyled">
                            @foreach($project->key_features as $feature)
                                <li class="d-flex gap-2 mb-2">
                                    <i class="ti ti-check text-primary flex-shrink-0 mt-1"></i>
                                    <span class="text-muted fs-13">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Skills --}}
                @if($project->skills->count())
                    <div>
                        <h6 class="fw-semibold mb-2">Technologies Used</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($project->skills as $skill)
                                <span class="badge bg-light text-dark border">
                        @if($skill->icon)
                                        <i class="{{ $skill->icon }} me-1"></i>
                                    @endif
                                    {{ $skill->name }}
                    </span>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- Related projects --}}
        @if($related->count())
            <div class="mt-5 pt-4 border-top">
                <h5 class="fw-semibold mb-4">Related Projects</h5>
                <div class="row g-4">
                    @foreach($related as $rel)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                @if($rel->coverImage)
                                    <div style="height:150px;overflow:hidden">
                                        <img src="{{ asset('storage/' . $rel->coverImage->path) }}"
                                             class="w-100 h-100" style="object-fit:cover" alt="{{ $rel->title }}">
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-1">{{ $rel->title }}</h6>
                                    <p class="text-muted fs-13 mb-3">{{ Str::limit($rel->summary, 80) }}</p>
                                    <a href="{{ route('projects.show', $rel->slug) }}"
                                       class="btn btn-sm btn-outline-dark">
                                        View Project
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
