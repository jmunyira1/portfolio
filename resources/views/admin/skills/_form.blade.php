<div class="mb-3">
    <label class="form-label">Category <span class="text-danger">*</span></label>
    <select name="skill_category_id" class="form-select @error('skill_category_id') is-invalid @enderror">
        <option value="">— Select Category —</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('skill_category_id', $skill->skill_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('skill_category_id')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Skill Name <span class="text-danger">*</span></label>
    <input type="text" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $skill->name ?? '') }}"
           placeholder="e.g. Laravel">
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">
        Proficiency — <span id="proficiency-value">{{ old('proficiency', $skill->proficiency ?? 50) }}%</span>
    </label>
    <input type="range" name="proficiency" id="proficiency-range"
           class="form-range"
           min="0" max="100" step="5"
           value="{{ old('proficiency', $skill->proficiency ?? 50) }}">
    <div class="d-flex justify-content-between">
        <div class="progress w-100 mt-1" style="height:6px">
            <div class="progress-bar bg-primary" id="proficiency-bar"
                 style="width:{{ old('proficiency', $skill->proficiency ?? 50) }}%"></div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Icon <span class="text-muted fs-12">(Tabler icon class)</span></label>
    <div class="input-group">
        <span class="input-group-text">
            <i class="{{ old('icon', $skill->icon ?? 'ti ti-code') }}" id="skill-icon-display"></i>
        </span>
        <input type="text" name="icon" id="skill-icon-input"
               class="form-control"
               value="{{ old('icon', $skill->icon ?? '') }}"
               placeholder="e.g. ti ti-brand-laravel">
    </div>
    <div class="form-text">
        Browse at <a href="https://tabler.io/icons" target="_blank">tabler.io/icons</a>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Sort Order</label>
    <input type="number" name="sort_order" class="form-control"
           value="{{ old('sort_order', $skill->sort_order ?? 0) }}"
           min="0">
    <div class="form-text">Lower number appears first within the category.</div>
</div>

@push('scripts')
    <script>
        // Live proficiency preview
        const range = document.getElementById('proficiency-range');
        const label = document.getElementById('proficiency-value');
        const bar = document.getElementById('proficiency-bar');

        range.addEventListener('input', function () {
            label.textContent = this.value + '%';
            bar.style.width = this.value + '%';
        });

        // Live icon preview
        document.getElementById('skill-icon-input').addEventListener('input', function () {
            document.getElementById('skill-icon-display').className = this.value;
        });
    </script>
@endpush
