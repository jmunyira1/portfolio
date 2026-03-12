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
                    <form method="POST" action="{{ route('admin.settings.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Avatar --}}
                        <div class="mb-4 text-center">
                            @if(!empty($settings['avatar']))
                                <img src="{{ asset('storage/' . $settings['avatar']) }}"
                                     alt="avatar"
                                     width="100" height="100"
                                     class="rounded-circle object-fit-cover border mb-2 d-block mx-auto">
                            @else
                                <div class="avatar-lg bg-light rounded-circle d-flex align-items-center
                                        justify-content-center mx-auto mb-2">
                                    <i class="ti ti-user fs-32 text-muted"></i>
                                </div>
                            @endif
                            <label class="form-label fw-medium">Profile Photo</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <div class="form-text">JPG, PNG or WEBP. Recommended: square, at least 200×200px.</div>
                        </div>

                        <hr class="mb-4">

                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $settings['name'] ?? '') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="tagline"
                                   class="form-control"
                                   value="{{ old('tagline', $settings['tagline'] ?? '') }}"
                                   placeholder="e.g. Full Stack Developer · Android Developer">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" rows="4"
                                      class="form-control @error('bio') is-invalid @enderror"
                                      placeholder="A short paragraph about yourself...">{{ old('bio', $settings['bio'] ?? '') }}</textarea>
                            @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location"
                                       class="form-control"
                                       value="{{ old('location', $settings['location'] ?? '') }}"
                                       placeholder="e.g. Nairobi, Kenya">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Email <span class="text-danger">*</span></label>
                                <input type="email" name="contact_email"
                                       class="form-control @error('contact_email') is-invalid @enderror"
                                       value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                                @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                Resume Path
                                <span class="text-muted fs-12">(relative to public/ e.g. resume.pdf)</span>
                            </label>
                            <input type="text" name="resume_path"
                                   class="form-control"
                                   value="{{ old('resume_path', $settings['resume_path'] ?? '') }}"
                                   placeholder="resume.pdf">
                            <div class="form-text">
                                Place your PDF in the <code>public/</code> folder then enter the filename here.
                            </div>
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
