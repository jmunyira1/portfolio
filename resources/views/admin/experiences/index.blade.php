@extends('layouts.admin')

@section('title', 'Experience')
@section('page-title', 'Work Experience')

@section('breadcrumb')
    <li class="breadcrumb-item active">Experience</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Experience Records</h5>
                    <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i> Add Experience
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Client</th>
                                <th>Period</th>
                                <th>Responsibilities</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($experiences as $exp)
                                <tr>
                                    <td class="fw-semibold">{{ $exp->title }}</td>
                                    <td>{{ $exp->client->name }}</td>
                                    <td class="text-nowrap">
                                        {{ $exp->start_date->format('M Y') }} —
                                        {{ $exp->is_current ? 'Present' : $exp->end_date?->format('M Y') }}
                                    </td>
                                    <td>
                                    <span class="badge bg-info-subtle text-info">
                                        {{ count($exp->responsibilities) }} items
                                    </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.experiences.edit', $exp) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.experiences.destroy', $exp) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this experience?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No experience records yet.</td>
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
