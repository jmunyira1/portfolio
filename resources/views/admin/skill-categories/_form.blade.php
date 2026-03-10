<div class="mb-3">
    <label class="form-label">Category Name <span class="text-danger">*</span></label>
    <input type="text" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $skillCategory->name ?? '') }}"
           placeholder="e.g. Web Development">
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Icon <span class="text-muted fs-12">(Tabler icon class)</span></label>
    <div class="input-group">
        <span class="input-group-text" id="icon-preview">
            <i class="{{ old('icon', $skillCategory->icon ?? 'ti ti-code') }}" id="icon-display"></i>
        </span>
        <input type="text" name="icon" id="icon-input"
               class="form-control"
               value="{{ old('icon', $skillCategory->icon ?? '') }}"
               placeholder="e.g. ti ti-code">
    </div>
    <div class="form-text">
        Browse at <a href="https://tabler.io/icons" target="_blank">tabler.io/icons</a>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="3" class="form-control"
              placeholder="Brief description of this category...">{{ old('description', $skillCategory->description ?? '') }}</textarea>
</div>

@push('scripts')
    <script>
        document.getElementById('icon-input').addEventListener('input', function () {
            document.getElementById('icon-display').className = this.value;
        });
    </script>
@endpush
