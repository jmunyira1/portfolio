<div class="row">

    {{-- Left column — main details --}}
    <div class="col-xl-8">

        {{-- Basic Info --}}
        <div class="card mb-3">
            <div class="card-header"><h5 class="card-title mb-0">Project Details</h5></div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $project->title ?? '') }}"
                           placeholder="e.g. QR Book Management System">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Summary <span class="text-danger">*</span></label>
                    <textarea name="summary" rows="2"
                              class="form-control @error('summary') is-invalid @enderror"
                              placeholder="Short description shown on project cards...">{{ old('summary', $project->summary ?? '') }}</textarea>
                    @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Full Description</label>
                    <textarea name="description" rows="5" class="form-control"
                              placeholder="Detailed description of the project...">{{ old('description', $project->description ?? '') }}</textarea>
                </div>

                {{-- Key Features --}}
                <div class="mb-3">
                    <label class="form-label">Key Features</label>
                    <div id="features-list">
                        @php
                            $features = old('key_features', $project->key_features ?? ['']);
                        @endphp
                        @foreach($features as $feature)
                            <div class="input-group mb-2 feature-item">
                                <input type="text" name="key_features[]"
                                       class="form-control"
                                       value="{{ $feature }}"
                                       placeholder="Describe a key feature...">
                                <button type="button" class="btn btn-outline-danger remove-feature">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature">
                        <i class="ti ti-plus me-1"></i> Add Feature
                    </button>
                </div>

                {{-- URLs --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Live URL</label>
                        <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                               value="{{ old('url', $project->url ?? '') }}"
                               placeholder="https://...">
                        @error('url')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">GitHub URL</label>
                        <input type="url" name="github_url"
                               class="form-control @error('github_url') is-invalid @enderror"
                               value="{{ old('github_url', $project->github_url ?? '') }}"
                               placeholder="https://github.com/...">
                        @error('github_url')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div>
        </div>

        {{-- Images --}}
        <div class="card mb-3">
            <div class="card-header"><h5 class="card-title mb-0">Images <span class="text-muted fs-13">(first image = cover)</span>
                </h5></div>
            <div class="card-body">

                {{-- Existing images --}}
                @if(isset($project) && $project->images->count())
                    <div class="row g-2 mb-3" id="existing-images">
                        @foreach($project->images as $image)
                            <div class="col-auto" id="img-{{ $image->id }}">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $image->path) }}"
                                         alt="project image"
                                         class="rounded border"
                                         style="width:100px;height:75px;object-fit:cover">
                                    @if($loop->first)
                                        <span class="position-absolute top-0 start-0 badge bg-primary m-1"
                                              style="font-size:9px">Cover</span>
                                    @endif
                                    <form method="POST"
                                          action="{{ route('admin.project-images.destroy', $image) }}"
                                          onsubmit="return confirm('Delete this image?')"
                                          class="position-absolute top-0 end-0 m-1">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon btn-xs p-0"
                                                style="width:20px;height:20px;font-size:10px">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mb-2">
                    <label class="form-label">
                        {{ isset($project) && $project->images->count() ? 'Add More Images' : 'Upload Images' }}
                    </label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*" id="image-input">
                    <div class="form-text">JPG, PNG, WEBP — max 4MB each. Multiple allowed.</div>
                </div>

                {{-- Image preview --}}
                <div class="row g-2 mt-1" id="image-preview"></div>

            </div>
        </div>

        {{-- Skills --}}
        <div class="card mb-3">
            <div class="card-header"><h5 class="card-title mb-0">Skills Used</h5></div>
            <div class="card-body">
                @php
                    $selectedSkills = old('skills', isset($project) ? $project->skills->pluck('id')->toArray() : []);
                    $grouped = $skills->groupBy(fn($s) => $s->category->name);
                @endphp

                @foreach($grouped as $categoryName => $categorySkills)
                    <div class="mb-3">
                        <p class="text-muted fs-12 fw-semibold text-uppercase mb-2">{{ $categoryName }}</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($categorySkills as $skill)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="skills[]" id="skill-{{ $skill->id }}"
                                           value="{{ $skill->id }}"
                                        {{ in_array($skill->id, $selectedSkills) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="skill-{{ $skill->id }}">
                                        @if($skill->icon)
                                            <i class="{{ $skill->icon }} me-1"></i>
                                        @endif
                                        {{ $skill->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @error('skills')
                <div class="text-danger fs-12">{{ $message }}</div> @enderror
            </div>
        </div>

    </div>

    {{-- Right column — meta --}}
    <div class="col-xl-4">
        <div class="card mb-3">
            <div class="card-header"><h5 class="card-title mb-0">Meta</h5></div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_software"
                                   id="type-software" value="1"
                                {{ old('is_software', $project->is_software ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="type-software">Software</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_software"
                                   id="type-technical" value="0"
                                {{ !old('is_software', $project->is_software ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="type-technical">Technical</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="skill_category_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('skill_category_id', $project->skill_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Client</label>
                    <select name="client_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $project->client_id ?? '') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0">
                </div>

                <div class="mb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="featured"
                               id="featured" value="1"
                            {{ old('featured', $project->featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">
                            Featured <span class="text-muted fs-12">(show on homepage)</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="published"
                               id="published" value="1"
                            {{ old('published', $project->published ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="published">Published</label>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-device-floppy me-1"></i>
                        {{ isset($project) ? 'Update' : 'Save' }} Project
                    </button>
                </div>
                <div class="mt-2">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary w-100">
                        Cancel
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        // ── Key features ──────────────────────────────────────────────
        document.getElementById('add-feature').addEventListener('click', function () {
            const list = document.getElementById('features-list');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 feature-item';
            div.innerHTML = `
            <input type="text" name="key_features[]" class="form-control"
                   placeholder="Describe a key feature...">
            <button type="button" class="btn btn-outline-danger remove-feature">
                <i class="ti ti-trash"></i>
            </button>
        `;
            list.appendChild(div);
            div.querySelector('input').focus();
        });

        document.getElementById('features-list').addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-feature');
            if (!btn) return;
            const items = document.querySelectorAll('.feature-item');
            if (items.length > 1) btn.closest('.feature-item').remove();
        });

        // ── Image preview ─────────────────────────────────────────────
        document.getElementById('image-input').addEventListener('change', function () {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            Array.from(this.files).forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const col = document.createElement('div');
                    col.className = 'col-auto';
                    col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="rounded border"
                             style="width:100px;height:75px;object-fit:cover">
                        ${i === 0 && !document.querySelector('#existing-images') ? '<span class="position-absolute top-0 start-0 badge bg-primary m-1" style="font-size:9px">Cover</span>' : ''}
                    </div>
                `;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
