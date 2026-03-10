@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    <div class="row">

        {{-- Stats cards --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fs-13">Projects</p>
                            <h4 class="mb-0 fw-bold">0</h4>
                        </div>
                        <div class="avatar-md bg-primary-subtle rounded">
                            <i class="ti ti-layout-grid fs-24 text-primary d-flex align-items-center justify-content-center h-100"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fs-13">Blog Posts</p>
                            <h4 class="mb-0 fw-bold">0</h4>
                        </div>
                        <div class="avatar-md bg-success-subtle rounded">
                            <i class="ti ti-news fs-24 text-success d-flex align-items-center justify-content-center h-100"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fs-13">Skills</p>
                            <h4 class="mb-0 fw-bold">0</h4>
                        </div>
                        <div class="avatar-md bg-warning-subtle rounded">
                            <i class="ti ti-bulb fs-24 text-warning d-flex align-items-center justify-content-center h-100"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fs-13">Messages</p>
                            <h4 class="mb-0 fw-bold">0</h4>
                        </div>
                        <div class="avatar-md bg-info-subtle rounded">
                            <i class="ti ti-mail fs-24 text-info d-flex align-items-center justify-content-center h-100"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-2">

        {{-- Quick links --}}
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus me-1"></i> New Project
                        </a>
                        <a href="" class="btn btn-success btn-sm">
                            <i class="ti ti-plus me-1"></i> New Post
                        </a>
                        <a href="" class="btn btn-warning btn-sm">
                            <i class="ti ti-bulb me-1"></i> Manage Skills
                        </a>
                        <a href="" class="btn btn-info btn-sm">
                            <i class="ti ti-mail me-1"></i> View Messages
                        </a>
                        <a href="" class="btn btn-secondary btn-sm">
                            <i class="ti ti-settings me-1"></i> Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Welcome card --}}
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Welcome back 👋</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-1">
                        Logged in as <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span>
                    </p>
                    <p class="text-muted mb-0 fs-13">
                        Manage your portfolio content from the sidebar.
                        <a href="{{ route('home') }}" target="_blank">View live site <i
                                class="ti ti-external-link ms-1"></i></a>
                    </p>
                </div>
            </div>
        </div>

    </div>

@endsection
