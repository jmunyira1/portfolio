@extends('layouts.admin')

@section('title', 'Edit Social')
@section('page-title', 'Edit Social Link')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.socials.index') }}">Socials</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.socials.update', $social) }}">
                        @csrf @method('PUT')
                        @include('admin.socials._form')
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Update
                            </button>
                            <a href="{{ route('admin.socials.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
