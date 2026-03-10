@extends('layouts.admin')

@section('title', 'Skill Categories')
@section('page-title', 'Skill Categories')

@section('breadcrumb')
    <li class="breadcrumb-item active">Skill Categories</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">All Categories</h5>
                    <a href="{{ route('admin.skill-categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i> Add Category
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Skills</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>
                                        @if($category->icon)
                                            <i class="{{ $category->icon }} me-1"></i>
                                        @endif
                                        <span class="fw-semibold">{{ $category->name }}</span>
                                    </td>
                                    <td class="text-muted fs-13">{{ $category->description ?? '—' }}</td>
                                    <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $category->skills_count }}
                                    </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.skill-categories.edit', $category) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('admin.skill-categories.destroy', $category) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this category and all its skills?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No categories yet.</td>
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
