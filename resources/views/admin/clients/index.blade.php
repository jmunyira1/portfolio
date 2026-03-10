@extends('layouts.admin')

@section('title', 'Clients')
@section('page-title', 'Clients')

@section('breadcrumb')
    <li class="breadcrumb-item active">Clients</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Clients</h5>
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i> Add Client
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Experiences</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td class="fw-semibold">{{ $client->name }}</td>
                                    <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $client->experiences_count }}
                                    </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.clients.edit', $client) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.clients.destroy', $client) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this client?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No clients yet.</td>
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
