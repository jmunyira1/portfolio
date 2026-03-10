@extends('layouts.admin')

@section('title', 'Projects')
@section('page-title', 'Projects')

@section('breadcrumb')
    <li class="breadcrumb-item active">Projects</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">All Projects</h5>
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm" id="type-filter" style="width:160px">
                            <option value="">All Types</option>
                            <option value="software">Software</option>
                            <option value="technical">Technical</option>
                        </select>
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus me-1"></i> Add Project
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width:60px">Image</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Client</th>
                                <th>Featured</th>
                                <th>Published</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($projects as $project)
                                <tr data-type="{{ $project->is_software ? 'software' : 'technical' }}">
                                    <td>
                                        @if($project->coverImage)
                                            <img src="{{ asset('storage/' . $project->coverImage->path) }}"
                                                 alt="{{ $project->title }}"
                                                 class="rounded" width="48" height="36"
                                                 style="object-fit:cover">
                                        @else
                                            <div
                                                class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width:48px;height:36px">
                                                <i class="ti ti-photo text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $project->title }}</span>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($project->summary, 60) }}</small>
                                    </td>
                                    <td>
                                        @if($project->is_software)
                                            <span class="badge bg-primary-subtle text-primary">Software</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Technical</span>
                                        @endif
                                    </td>
                                    <td class="text-muted fs-13">{{ $project->category?->name ?? '—' }}</td>
                                    <td class="text-muted fs-13">{{ $project->client?->name ?? '—' }}</td>
                                    <td>
                                        @if($project->featured)
                                            <i class="ti ti-star-filled text-warning"></i>
                                        @else
                                            <i class="ti ti-star text-muted"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->published)
                                            <span class="badge bg-success-subtle text-success">Live</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.projects.edit', $project) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this project and all its images?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No projects yet.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('type-filter').addEventListener('change', function () {
            const val = this.value;
            document.querySelectorAll('tbody tr[data-type]').forEach(row => {
                row.style.display = (!val || row.dataset.type === val) ? '' : 'none';
            });
        });
    </script>
@endpush
