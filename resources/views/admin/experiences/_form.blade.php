<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Client <span class="text-danger">*</span></label>
        <select name="client_id" class="form-select @error('client_id') is-invalid @enderror">
            <option value="">— Select Client —</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}"
                    {{ old('client_id', $experience->client_id ?? '') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
        @error('client_id')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Job Title <span class="text-danger">*</span></label>
        <input type="text" name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $experience->title ?? '') }}"
               placeholder="e.g. Software Developer">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Start Date <span class="text-danger">*</span></label>
        <input type="date" name="start_date"
               class="form-control @error('start_date') is-invalid @enderror"
               value="{{ old('start_date', isset($experience) ? $experience->start_date->format('Y-m-d') : '') }}">
        @error('start_date')
        <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">End Date</label>
        <input type="date" name="end_date" id="end_date"
               class="form-control"
               value="{{ old('end_date', isset($experience) && $experience->end_date ? $experience->end_date->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4 mb-3 d-flex align-items-end pb-1">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_current"
                   id="is_current" value="1"
                   {{ old('is_current', $experience->is_current ?? false) ? 'checked' : '' }}
                   onchange="document.getElementById('end_date').disabled = this.checked">
            <label class="form-check-label" for="is_current">Currently working here</label>
        </div>
    </div>
</div>

{{-- Responsibilities --}}
<div class="mb-3">
    <label class="form-label">Responsibilities <span class="text-danger">*</span></label>

    <div id="responsibilities-list">
        @php
            $responsibilities = old('responsibilities', $experience->responsibilities ?? ['']);
        @endphp

        @foreach($responsibilities as $i => $item)
            <div class="input-group mb-2 responsibility-item">
                <input type="text" name="responsibilities[]"
                       class="form-control"
                       value="{{ $item }}"
                       placeholder="Describe a responsibility...">
                <button type="button" class="btn btn-outline-danger remove-responsibility">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-outline-primary btn-sm mt-1" id="add-responsibility">
        <i class="ti ti-plus me-1"></i> Add Responsibility
    </button>

    @error('responsibilities')
    <div class="text-danger fs-12 mt-1">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    <script>
        // Add responsibility
        document.getElementById('add-responsibility').addEventListener('click', function () {
            const list = document.getElementById('responsibilities-list');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 responsibility-item';
            div.innerHTML = `
            <input type="text" name="responsibilities[]"
                   class="form-control"
                   placeholder="Describe a responsibility...">
            <button type="button" class="btn btn-outline-danger remove-responsibility">
                <i class="ti ti-trash"></i>
            </button>
        `;
            list.appendChild(div);
            div.querySelector('input').focus();
        });

        // Remove responsibility (delegated)
        document.getElementById('responsibilities-list').addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-responsibility');
            if (!btn) return;
            const items = document.querySelectorAll('.responsibility-item');
            if (items.length > 1) {
                btn.closest('.responsibility-item').remove();
            }
        });
    </script>
@endpush
