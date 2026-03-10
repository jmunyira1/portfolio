@extends('layouts.admin')

@section('title', 'Edit Education')
@section('page-title', 'Edit Education')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.education.index') }}">Education</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.education.update', $education) }}">
                        @csrf @method('PUT')
                        @include('admin.education._form')
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Update
                            </button>
                            <a href="{{ route('admin.education.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
