@extends('layouts.app')

@section('title', $project['title'])
@section('meta_description', $project['summary'])

@section('content')
    <div class="py-4">

        <a href="{{ route('home') }}#projects" class="btn btn-outline-secondary btn-sm mb-4">
            <i class="ti ti-arrow-left me-1"></i> Back to Projects
        </a>

        <div class="row g-5">

            {{-- Left — carousel --}}
            <div class="col-lg-7">
                @if(!empty($project['screenshots']))
                    <div id="projectCarousel" class="carousel slide rounded overflow-hidden border"
                         data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($project['screenshots'] as $i => $url)
                                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                    <img src="{{ $url }}"
                                         class="d-block w-100 object-fit-cover"
                                         alt="{{ $project['title'] }}"
                                         style="height:380px">
                                </div>
                            @endforeach
                        </div>
                        @if(count($project['screenshots']) > 1)
                            <button class="carousel-control-prev" type="button"
                                    data-bs-target="#projectCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                    data-bs-target="#projectCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            {{-- Thumbnail strip --}}
                            @if(count($project['screenshots']) > 1)
                                <div class="d-flex gap-1 p-2 overflow-auto">
                                    @foreach($project['screenshots'] as $i => $url)
                                        <img src="{{ $url }}"
                                             class="rounded border object-fit-cover flex-shrink-0"
                                             style="width:64px;height:44px;cursor:pointer;
                                opacity:{{ $i === 0 ? '1' : '0.55' }}"
                                             onclick="
                            bootstrap.Carousel.getInstance(
                                document.getElementById('projectCarousel')
                            ).to({{ $i }});
                            document.querySelectorAll('#thumb-strip img')
                                .forEach((t,j) => t.style.opacity = j==={{ $i }} ? '1':'0.55');
                         "
                                             id="thumb-strip">
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                @else
                    <div class="bg-light rounded border d-flex align-items-center
                        justify-content-center" style="height:380px">
                        <i class="ti ti-photo text-muted fs-48"></i>
                    </div>
                @endif
            </div>

            {{-- Right — details --}}
            <div class="col-lg-5">

                <h1 class="fw-bold mb-2 fs-3">{{ $project['title'] }}</h1>

                <p class="text-muted mb-4">{{ $project['description'] ?: $project['summary'] }}</p>

                {{-- Links --}}
                <div class="d-flex gap-2 mb-4">
                    @if(!empty($project['live_url']))
                        <a href="{{ $project['live_url'] }}" target="_blank" class="btn btn-dark btn-sm px-3">
                            <i class="ti ti-external-link me-1"></i> Live Site
                        </a>
                    @endif
                    @if(!empty($project['github_url']))
                        <a href="{{ $project['github_url'] }}" target="_blank"
                           class="btn btn-outline-secondary btn-sm px-3">
                            <i class="ti ti-brand-github me-1"></i> GitHub
                        </a>
                    @endif
                </div>

                {{-- Tech stack --}}
                @if(!empty($project['tech']))
                    <div class="mb-4">
                        <p class="fs-12 fw-semibold text-uppercase text-muted letter-spacing-1 mb-2">
                            Tech Stack
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($project['tech'] as $tech)
                                <span class="badge bg-light text-muted border fw-normal fs-12">
                        {{ $tech }}
                    </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- README body (repo projects only) --}}
                @if(!empty($project['readme_body']))
                    <div class="mb-2">
                        <p class="fs-12 fw-semibold text-uppercase text-muted letter-spacing-1 mb-2">
                            About this project
                        </p>
                        <div class="text-muted fs-13">
                            {!! \Illuminate\Support\Str::markdown($project['readme_body']) !!}
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- Related --}}
        @if($related->count())
            <div class="mt-5 pt-4 border-top">
                <h5 class="fw-semibold mb-4 fs-14 text-uppercase text-muted letter-spacing-1">
                    More Projects
                </h5>
                <div class="row g-3">
                    @foreach($related as $rel)
                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100 d-flex flex-column">
                                @if(!empty($rel['cover']))
                                    <a href="{{ route('projects.show', $rel['slug']) }}"
                                       class="d-block rounded overflow-hidden mb-3">
                                        <img src="{{ $rel['cover'] }}"
                                             class="w-100 object-fit-cover rounded"
                                             alt="{{ $rel['title'] }}"
                                             style="height:120px">
                                    </a>
                                @endif
                                <a href="{{ route('projects.show', $rel['slug']) }}"
                                   class="fw-semibold text-body text-decoration-none fs-14 mb-1">
                                    {{ $rel['title'] }}
                                </a>
                                <p class="text-muted fs-13 mb-3 flex-grow-1">
                                    {{ Str::limit($rel['summary'], 80) }}
                                </p>
                                <a href="{{ route('projects.show', $rel['slug']) }}"
                                   class="btn btn-outline-secondary btn-sm fs-12 mt-auto">
                                    View project
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
