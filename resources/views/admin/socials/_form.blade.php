<div class="mb-3">
    <label class="form-label">Platform <span class="text-danger">*</span></label>
    <input type="text" name="platform"
           class="form-control @error('platform') is-invalid @enderror"
           value="{{ old('platform', $social->platform ?? '') }}"
           placeholder="e.g. GitHub">
    @error('platform')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Label <span class="text-danger">*</span></label>
    <input type="text" name="label"
           class="form-control @error('label') is-invalid @enderror"
           value="{{ old('label', $social->label ?? '') }}"
           placeholder="e.g. GitHub">
    @error('label')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Display Value <span class="text-danger">*</span></label>
    <input type="text" name="value"
           class="form-control @error('value') is-invalid @enderror"
           value="{{ old('value', $social->value ?? '') }}"
           placeholder="e.g. @jmunyira1">
    @error('value')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">URL <span class="text-danger">*</span></label>
    <input type="text" name="url"
           class="form-control @error('url') is-invalid @enderror"
           value="{{ old('url', $social->url ?? '') }}"
           placeholder="e.g. https://github.com/jmunyira1">
    @error('url')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Icon <span class="text-muted fs-12">(Tabler icon class)</span></label>
    <input type="text" name="icon"
           class="form-control"
           value="{{ old('icon', $social->icon ?? '') }}"
           placeholder="e.g. ti ti-brand-github">
    <div class="form-text">
        Browse icons at
        <a href="https://tabler.io/icons" target="_blank">tabler.io/icons</a>
    </div>
</div>

<div class="mb-3">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" name="is_primary" id="is_primary" value="1"
            {{ old('is_primary', $social->is_primary ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_primary">
            Primary contact <span class="text-muted fs-12">(shown prominently on contact section)</span>
        </label>
    </div>
</div>
