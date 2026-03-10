<div class="mb-3">
    <label class="form-label">Institution <span class="text-danger">*</span></label>
    <input type="text" name="institution"
           class="form-control @error('institution') is-invalid @enderror"
           value="{{ old('institution', $education->institution ?? '') }}">
    @error('institution')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Degree Level <span class="text-danger">*</span></label>
        <select name="degree_level" class="form-select @error('degree_level') is-invalid @enderror">
            <option value="">— Select —</option>
            @foreach(["Certificate", "Diploma", "Bachelor's", "Master's", "PhD", "Other"] as $level)
                <option value="{{ $level }}"
                    {{ old('degree_level', $education->degree_level ?? '') === $level ? 'selected' : '' }}>
                    {{ $level }}
                </option>
            @endforeach
        </select>
        @error('degree_level')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Field of Study</label>
        <input type="text" name="field_of_study" class="form-control"
               value="{{ old('field_of_study', $education->field_of_study ?? '') }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Degree / Qualification <span class="text-danger">*</span></label>
    <input type="text" name="degree"
           class="form-control @error('degree') is-invalid @enderror"
           value="{{ old('degree', $education->degree ?? '') }}"
           placeholder="e.g. Bsc. Information Security and Forensics">
    @error('degree')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Start Year <span class="text-danger">*</span></label>
        <input type="number" name="start_year" class="form-control @error('start_year') is-invalid @enderror"
               value="{{ old('start_year', $education->start_year ?? '') }}"
               min="1990" max="{{ date('Y') }}">
        @error('start_year')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">End Year</label>
        <input type="number" name="end_year" class="form-control"
               value="{{ old('end_year', $education->end_year ?? '') }}"
               min="1990" max="{{ date('Y') + 5 }}"
               id="end_year">
    </div>
    <div class="col-md-4 mb-3 d-flex align-items-end pb-1">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_current"
                   id="is_current" value="1"
                   {{ old('is_current', $education->is_current ?? false) ? 'checked' : '' }}
                   onchange="document.getElementById('end_year').disabled = this.checked">
            <label class="form-check-label" for="is_current">Currently enrolled</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Grade / Result</label>
        <input type="text" name="grade" class="form-control"
               value="{{ old('grade', $education->grade ?? '') }}"
               placeholder="e.g. Second Upper">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control"
               value="{{ old('location', $education->location ?? '') }}"
               placeholder="e.g. Nairobi, Kenya">
    </div>
</div>
