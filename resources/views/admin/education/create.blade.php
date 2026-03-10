@extends('layouts.admin')

@section('title', 'Add Education')
@section('page-title', 'Add Education')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.education.index') }}">Education</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.education.store') }}">
                        @csrf
                        @include('admin.education._form')
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Save
                            </button>
                            <a href="{{ route('admin.education.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
