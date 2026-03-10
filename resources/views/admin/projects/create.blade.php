@extends('layouts.admin')

@section('title', 'Add Project')
@section('page-title', 'Add Project')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.projects._form')
    </form>
@endsection
