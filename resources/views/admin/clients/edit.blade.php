@extends('layouts.admin')

@section('title', 'Edit Client')
@section('page-title', 'Edit Client')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clients</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.clients.update', $client) }}">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $client->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Update
                            </button>
                            <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
