@extends('layouts.admin')

@section('title', 'Edit ' . $project['title'])
@section('page-title', 'Edit Project README')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.repo-projects.index') }}">Software Projects</a>
    </li>
    <li class="breadcrumb-item active">{{ $project['title'] }}</li>
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- ── Left — README form ── --}}
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-file-text me-1"></i> README Frontmatter
                    </h5>
                    <span class="badge bg-light text-muted border font-monospace fs-11">
                    {{ $project['slug'] }}/README.md
                </span>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('admin.repo-projects.update', $project['slug']) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $project['title']) }}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Summary <span class="text-danger">*</span>
                                    <span class="text-muted fs-12">(one line — shown on project cards)</span>
                                </label>
                                <input type="text" name="summary"
                                       class="form-control @error('summary') is-invalid @enderror"
                                       value="{{ old('summary', $project['summary']) }}">
                                @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Description
                                    <span class="text-muted fs-12">(paragraph — shown on project detail page)</span>
                                </label>
                                <textarea name="description" rows="3"
                                          class="form-control">{{ old('description', $project['description']) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Tech Stack
                                    <span class="text-muted fs-12">(comma separated — e.g. PHP, Laravel, MySQL)</span>
                                </label>
                                <input type="text" name="tech"
                                       class="form-control"
                                       value="{{ old('tech', $project['tech']) }}"
                                       placeholder="PHP, Laravel, MySQL, Bootstrap">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Live URL</label>
                                <input type="url" name="live_url"
                                       class="form-control @error('live_url') is-invalid @enderror"
                                       value="{{ old('live_url', $project['live_url']) }}"
                                       placeholder="https://...">
                                @error('live_url')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">GitHub URL</label>
                                <input type="url" name="github_url"
                                       class="form-control @error('github_url') is-invalid @enderror"
                                       value="{{ old('github_url', $project['github_url']) }}"
                                       placeholder="https://github.com/...">
                                @error('github_url')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Order
                                    <span class="text-muted fs-12">(lower = first)</span>
                                </label>
                                <input type="number" name="order"
                                       class="form-control"
                                       value="{{ old('order', $project['order']) }}"
                                       min="1" placeholder="1">
                            </div>

                            <div class="col-md-4 d-flex align-items-end pb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                           name="featured" id="featured" value="1"
                                        {{ old('featured', $project['featured']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">Featured</label>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex align-items-end pb-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                           name="active" id="active" value="1"
                                        {{ old('active', $project['active']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        Active <span class="text-muted fs-12">(show on portfolio)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                                <label class="form-label">
                                    README Body
                                    <span class="text-muted fs-12">(Markdown — everything after the frontmatter)</span>
                                </label>
                                <textarea name="body" rows="16"
                                          class="form-control font-monospace fs-13"
                                          placeholder="## Features&#10;&#10;- ...&#10;&#10;## Installation&#10;&#10;...">{{ old('body', $project['body']) }}</textarea>
                            </div>

                            <div class="col-12 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Save README
                                </button>
                                <a href="{{ route('admin.repo-projects.index') }}"
                                   class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Right — Screenshots ── --}}
        <div class="col-xl-4">

            {{-- Upload --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-photo me-1"></i> Screenshots
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('admin.repo-projects.screenshots.upload', $project['slug']) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fs-13">
                                Upload to <code>{{ $project['slug'] }}/screenshots/</code>
                            </label>
                            <input type="file" name="screenshots[]"
                                   class="form-control form-control-sm"
                                   accept="image/*" multiple>
                            <div class="form-text">
                                First file (alphabetically) is used as the cover image.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            <i class="ti ti-upload me-1"></i> Upload
                        </button>
                    </form>
                </div>
            </div>

            {{-- Existing screenshots --}}
            @if(count($screenshots))
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0 fs-14">
                            Existing ({{ count($screenshots) }})
                            <span class="text-muted fs-12 fw-normal">— first = cover</span>
                        </h5>
                    </div>
                    <div class="card-body p-2">
                        @foreach($screenshots as $i => $shot)
                            <div class="d-flex align-items-center gap-2 p-2 border rounded mb-2">
                                <img src="{{ $shot['url'] }}"
                                     alt="{{ $shot['name'] }}"
                                     width="64" height="44"
                                     class="rounded object-fit-cover flex-shrink-0">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-0 fs-12 text-muted text-truncate">{{ $shot['name'] }}</p>
                                    @if($i === 0)
                                        <span class="badge bg-primary-subtle text-primary fs-10">Cover</span>
                                    @endif
                                </div>
                                <form method="POST"
                                      action="{{ route('admin.repo-projects.screenshots.destroy', $project['slug']) }}"
                                      onsubmit="return confirm('Delete {{ $shot['name'] }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="file" value="{{ $shot['name'] }}">
                                    <button type="submit"
                                            class="btn btn-sm btn-link text-danger p-0">
                                        <i class="ti ti-trash fs-16"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center text-muted py-4 fs-13">
                        <i class="ti ti-photo-off fs-32 d-block mb-2"></i>
                        No screenshots yet.<br>Upload above to add some.
                    </div>
                </div>
            @endif

        </div>

    </div>

@endsection
