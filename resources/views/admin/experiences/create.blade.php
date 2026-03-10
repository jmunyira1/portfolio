@extends('layouts.admin')

@section('title', 'Add Experience')
@section('page-title', 'Add Experience')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.experiences.index') }}">Experience</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.experiences.store') }}">
                        @csrf
                        @include('admin.experiences._form')
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Save
                            </button>
                            <a href="{{ route('admin.experiences.index') }}"
                               class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
