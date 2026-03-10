@extends('layouts.admin')

@section('title', 'Add Category')
@section('page-title', 'Add Skill Category')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.skill-categories.index') }}">Skill Categories</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.skill-categories.store') }}">
                        @csrf
                        @include('admin.skill-categories._form')
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Save
                            </button>
                            <a href="{{ route('admin.skill-categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
