@extends('layouts.admin')

@section('title', 'Education')
@section('page-title', 'Education')

@section('breadcrumb')
    <li class="breadcrumb-item active">Education</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Education Records</h5>
                    <a href="{{ route('admin.education.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i> Add Education
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Institution</th>
                                <th>Degree</th>
                                <th>Years</th>
                                <th>Grade</th>
                                <th>Location</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($education as $edu)
                                <tr>
                                    <td class="fw-semibold">{{ $edu->institution }}</td>
                                    <td>
                                        {{ $edu->degree_level }} — {{ $edu->degree }}
                                        @if($edu->field_of_study)
                                            <br><small class="text-muted">{{ $edu->field_of_study }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $edu->start_year }} —
                                        {{ $edu->is_current ? 'Present' : $edu->end_year }}
                                    </td>
                                    <td>{{ $edu->grade ?? '—' }}</td>
                                    <td>{{ $edu->location ?? '—' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.education.edit', $edu) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.education.destroy', $edu) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this record?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No education records yet.</td>
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
