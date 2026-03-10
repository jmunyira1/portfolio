@extends('layouts.admin')

@section('title', 'Skills')
@section('page-title', 'Skills')

@section('breadcrumb')
    <li class="breadcrumb-item active">Skills</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">All Skills</h5>
                    <div class="d-flex gap-2">
                        {{-- Filter by category --}}
                        <select class="form-select form-select-sm" id="category-filter" style="width:180px">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('admin.skills.create') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus me-1"></i> Add Skill
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Skill</th>
                                <th>Category</th>
                                <th style="width:200px">Proficiency</th>
                                <th>Order</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($skills as $skill)
                                <tr data-category="{{ $skill->skill_category_id }}">
                                    <td>
                                        @if($skill->icon)
                                            <i class="{{ $skill->icon }} me-1"></i>
                                        @endif
                                        <span class="fw-semibold">{{ $skill->name }}</span>
                                    </td>
                                    <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $skill->category->name }}
                                    </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height:6px">
                                                <div class="progress-bar bg-primary"
                                                     style="width:{{ $skill->proficiency }}%"></div>
                                            </div>
                                            <span class="fs-12 text-muted" style="width:35px">
                                            {{ $skill->proficiency }}%
                                        </span>
                                        </div>
                                    </td>
                                    <td class="text-muted fs-13">{{ $skill->sort_order }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.skills.edit', $skill) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this skill?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No skills yet.</td>
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
        document.getElementById('category-filter').addEventListener('change', function () {
            const val = this.value;
            document.querySelectorAll('tbody tr[data-category]').forEach(row => {
                row.style.display = (!val || row.dataset.category === val) ? '' : 'none';
            });
        });
    </script>
@endpush
