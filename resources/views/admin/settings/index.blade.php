@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'Site Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile & Site Settings</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $settings['name'] ?? '') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="tagline"
                                   class="form-control @error('tagline') is-invalid @enderror"
                                   value="{{ old('tagline', $settings['tagline'] ?? '') }}">
                            @error('tagline')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" rows="4"
                                      class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $settings['bio'] ?? '') }}</textarea>
                            @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location"
                                       class="form-control @error('location') is-invalid @enderror"
                                       value="{{ old('location', $settings['location'] ?? '') }}">
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Email</label>
                                <input type="email" name="contact_email"
                                       class="form-control @error('contact_email') is-invalid @enderror"
                                       value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                                @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Resume Path <span
                                    class="text-muted fs-12">(e.g. resume.pdf)</span></label>
                            <input type="text" name="resume_path" class="form-control"
                                   value="{{ old('resume_path', $settings['resume_path'] ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Avatar</label>
                            @if(!empty($settings['avatar']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $settings['avatar']) }}"
                                         alt="avatar" class="rounded" height="60">
                                </div>
                            @endif
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
