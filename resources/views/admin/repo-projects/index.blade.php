@extends('layouts.admin')

@section('title', 'Software Projects')
@section('page-title', 'Software Projects')

@section('breadcrumb')
    <li class="breadcrumb-item active">Software Projects</li>
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">Repositories</h5>
            <span class="text-muted fs-13">Scanned from <code>{{ config('repos.path') }}</code></span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>Folder</th>
                    <th>Title</th>
                    <th>Summary</th>
                    <th>Screenshots</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td class="fs-13 text-muted font-monospace">{{ $project['slug'] }}</td>
                        <td class="fw-medium fs-14">{{ $project['title'] }}</td>
                        <td class="text-muted fs-13">
                            {{ $project['summary'] ? \Illuminate\Support\Str::limit($project['summary'], 60) : '—' }}
                        </td>
                        <td class="fs-13 text-muted">{{ $project['screenshots'] }}</td>
                        <td>
                            @if(!$project['has_readme'])
                                <span class="badge bg-danger-subtle text-danger">No README</span>
                            @elseif(!$project['valid'])
                                <span class="badge bg-warning-subtle text-warning">No frontmatter</span>
                            @elseif(!$project['active'])
                                <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                            @else
                                <span class="badge bg-success-subtle text-success">Active</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.repo-projects.edit', $project['slug']) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-pencil me-1"></i>
                                {{ $project['has_readme'] ? 'Edit' : 'Create README' }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No repositories found in <code>{{ config('repos.path') }}</code>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
