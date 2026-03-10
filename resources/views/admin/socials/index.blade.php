@extends('layouts.admin')

@section('title', 'Socials')
@section('page-title', 'Social Links')

@section('breadcrumb')
    <li class="breadcrumb-item active">Socials</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">All Social Links</h5>
                    <a href="{{ route('admin.socials.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i> Add Social
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Platform</th>
                                <th>Value</th>
                                <th>URL</th>
                                <th>Icon</th>
                                <th>Primary</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($socials as $social)
                                <tr>
                                    <td>
                                        @if($social->icon)
                                            <i class="{{ $social->icon }} me-1"></i>
                                        @endif
                                        {{ $social->label }}
                                    </td>
                                    <td>{{ $social->value }}</td>
                                    <td>
                                        <a href="{{ $social->url }}" target="_blank" class="text-muted fs-12">
                                            {{ Str::limit($social->url, 40) }}
                                        </a>
                                    </td>
                                    <td><code class="fs-12">{{ $social->icon }}</code></td>
                                    <td>
                                        @if($social->is_primary)
                                            <span class="badge bg-success-subtle text-success">Primary</span>
                                        @else
                                            <span class="badge bg-light text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.socials.edit', $social) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.socials.destroy', $social) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this social link?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No social links yet.</td>
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
