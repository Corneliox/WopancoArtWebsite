@extends('layouts.main')

@section('content')

{{-- Error Alert Block --}}
@if (session('error'))
    <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Whoops!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <div class="custom-block bg-white shadow-lg p-5">
                    
                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Edit Artwork</h3>
                        
                        @if(auth()->id() !== $artwork->user_id)
                            <a href="{{ route('artworks.index', ['user_id' => $artwork->user_id]) }}" class="btn custom-btn custom-border-btn btn-sm">
                                <i class="bi-arrow-left me-1"></i> Back to {{ $artwork->user->name }}'s Art
                            </a>
                        @else
                            <a href="{{ route('artworks.index') }}" class="btn custom-btn custom-border-btn btn-sm">Back to Dashboard</a>
                        @endif
                    </div>

                    @if(auth()->id() !== $artwork->user_id)
                        <div class="alert alert-warning p-3 mb-4">
                            <strong>Admin Mode:</strong> You are editing an artwork belonging to <u>{{ $artwork->user->name }}</u>.
                        </div>
                    @endif

                    <form action="{{ route('artworks.update', $artwork->id) }}" method="POST" enctype="multipart/form-data" id="artworkForm">
                        @csrf
                        @method('PATCH')

                        {{-- 1. BASIC INFO --}}
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $artwork->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" id="categorySelect" class="form-select" required>
                                <option value="" disabled>Select Category</option>
                                <option value="Lukisan" {{ old('category', $artwork->category) == 'Lukisan' ? 'selected' : '' }}>Lukisan (1 Image Max)</option>
                                <option value="Craft" {{ old('category', $artwork->category) == 'Craft' ? 'selected' : '' }}>Craft (Max 3 Images)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $artwork->description) }}</textarea>
                        </div>

                        <hr class="my-4">

                        {{-- 2. MAIN IMAGE (Dual Method: File or Link) --}}
                        <label class="form-label fw-bold">Main Artwork Image</label>
                        
                        {{-- Toggle Buttons --}}
                        <div class="mb-3">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-primary active" id="btnUploadMethod">
                                    <i class="bi-upload me-2"></i> Upload File
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="btnLinkMethod">
                                    <i class="bi-link-45deg me-2"></i> Upload via Link
                                </button>
                            </div>
                        </div>

                        {{-- SHARED PREVIEW CONTAINER --}}
                        {{-- This shows either the DB image, the selected file, or the pulled link --}}
                        <div class="mb-3 text-center p-3 bg-light border rounded position-relative" id="main_preview_container" style="min-height: 200px;">
                            <img id="mainPreview" 
                                    src="{{ Storage::url($artwork->image_path) }}" 
                                    class="img-fluid rounded shadow-sm" 
                                    style="max-height: 300px; transition: transform 0.3s ease;">
                            
                            <button type="button" id="main_rotate_btn" class="btn btn-dark btn-sm position-absolute bottom-0 end-0 m-3 shadow" title="Rotate 90° Right">
                                <i class="bi-arrow-clockwise"></i> Rotate
                            </button>
                        </div>

                        {{-- METHOD A: STANDARD FILE UPLOAD --}}
                        <div id="uploadInputSection">
                            <input type="file" name="image" id="main_file_input" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image.</small>
                        </div>

                        {{-- METHOD B: LINK PULLER --}}
                        <div id="linkInputSection" style="display: none;">
                            <label class="form-label small text-muted">Paste a direct link or a Google Drive sharing link</label>
                            <div class="input-group mb-2">
                                <input type="text" id="urlInput" class="form-control" placeholder="https://drive.google.com/file/d/...">
                                <button type="button" class="btn btn-dark" id="btnPullImage">
                                    <i class="bi-cloud-download me-1"></i> Pull Image
                                </button>
                            </div>
                            
                            {{-- Loading Spinner --}}
                            <div id="pullLoading" class="text-center text-primary mt-2" style="display:none;">
                                <div class="spinner-border spinner-border-sm" role="status"></div> Processing link...
                            </div>

                            {{-- Hidden Input for the pulled path --}}
                            <input type="hidden" name="image_temp_path" id="imageTempPath">
                            
                            <div id="pullError" class="text-danger small mt-2" style="display:none;"></div>
                        </div>

                        {{-- Rotation Input (Shared) --}}
                        <input type="hidden" name="rotation" id="main_rotation_input" value="0">

                        @error('image') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                        @error('image_temp_path') <p class="text-danger mt-1">{{ $message }}</p> @enderror

                        {{-- NEW: EXTRA IMAGES (Craft Only) --}}
                        <div id="extraImagesSection" class="mt-4 p-4 bg-light border rounded" style="{{ $artwork->category == 'Craft' ? '' : 'display:none;' }}">
                            <label class="form-label fw-bold text-primary mb-3">Additional Craft Images</label>
                            
                            {{-- Delete Existing --}}
                            @if($artwork->additional_images && count($artwork->additional_images) > 0)
                                <div class="row g-2 mb-4">
                                    <p class="small text-muted mb-2">Check to delete:</p>
                                    @foreach($artwork->additional_images as $path)
                                        <div class="col-4 text-center">
                                            <div class="border rounded p-2 bg-white h-100">
                                                <img src="{{ Storage::url($path) }}" class="img-fluid rounded mb-2" style="height: 80px; object-fit: cover;">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" name="delete_extras[]" value="{{ $path }}" id="del_{{ $loop->index }}">
                                                    <label class="form-check-label text-danger small fw-bold" for="del_{{ $loop->index }}">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Add New Extras --}}
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <label class="form-label small fw-bold">Add New Extra Image #1</label>
                                    <div class="mb-2 text-center p-2 bg-white border rounded position-relative" id="extra1_preview_container" style="display:none;">
                                        <img id="extra1_preview_img" src="#" class="img-fluid rounded" style="max-height: 200px; transition: transform 0.3s ease;">
                                        <button type="button" id="extra1_rotate_btn" class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-2 shadow"><i class="bi-arrow-clockwise"></i></button>
                                    </div>
                                    <input type="file" name="extra_images[0]" id="extra1_file_input" class="form-control form-control-sm" accept="image/*">
                                    <input type="hidden" name="extra_rotations[0]" id="extra1_rotation_input" value="0">
                                </div>
                            </div>

                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <label class="form-label small fw-bold">Add New Extra Image #2</label>
                                    <div class="mb-2 text-center p-2 bg-white border rounded position-relative" id="extra2_preview_container" style="display:none;">
                                        <img id="extra2_preview_img" src="#" class="img-fluid rounded" style="max-height: 200px; transition: transform 0.3s ease;">
                                        <button type="button" id="extra2_rotate_btn" class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-2 shadow"><i class="bi-arrow-clockwise"></i></button>
                                    </div>
                                    <input type="file" name="extra_images[1]" id="extra2_file_input" class="form-control form-control-sm" accept="image/*">
                                    <input type="hidden" name="extra_rotations[1]" id="extra2_rotation_input" value="0">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- 3. MARKETPLACE SETTINGS --}}
                        <h5 class="mb-3 text-primary">Marketplace Settings</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price (Rp)</label>
                                <input type="number" id="basePrice" name="price" class="form-control" placeholder="Optional" value="{{ old('price', $artwork->price) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $artwork->stock) }}">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_promo" name="is_promo" value="1" {{ old('is_promo', $artwork->is_promo) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_promo">Enable Promo / Discount?</label>
                        </div>

                        <div class="mb-4 p-3 border rounded bg-light" id="promo_price_wrapper" style="{{ old('is_promo', $artwork->is_promo) ? '' : 'display:none;' }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Discount Percentage (%)</label>
                                    <div class="input-group">
                                        <input type="number" id="discountPercent" class="form-control" placeholder="e.g. 20" min="0" max="99">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Final Promo Price (Rp)</label>
                                    <input type="number" id="promoPrice" name="promo_price" class="form-control" value="{{ old('promo_price', $artwork->promo_price) }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn custom-btn w-100 mt-3">Update Artwork</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // ==========================================
    // 1. REUSABLE IMAGE PREVIEW & ROTATE LOGIC
    // ==========================================
    function setupImagePreview(inputId, containerId, imgId, btnId, rotationId) {
        const input = document.getElementById(inputId);
        const container = document.getElementById(containerId);
        const img = document.getElementById(imgId);
        const btn = document.getElementById(btnId);
        const rotInput = document.getElementById(rotationId);
        
        let currentRotation = 0;

        // File Select Event
        if(input) {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        // For extras, show container. For Main, it's always shown but src updates.
                        if(container.style.display === 'none') container.style.display = 'block';
                        
                        currentRotation = 0;
                        rotInput.value = 0;
                        img.style.transform = 'rotate(0deg)';
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Rotate Button Event
        if(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                currentRotation = (currentRotation + 90) % 360;
                img.style.transform = `rotate(${currentRotation}deg)`;
                rotInput.value = currentRotation;
            });
        }
    }

    // Initialize Standard Inputs
    setupImagePreview('main_file_input', 'main_preview_container', 'main_preview_img', 'main_rotate_btn', 'main_rotation_input');
    setupImagePreview('extra1_file_input', 'extra1_preview_container', 'extra1_preview_img', 'extra1_rotate_btn', 'extra1_rotation_input');
    setupImagePreview('extra2_file_input', 'extra2_preview_container', 'extra2_preview_img', 'extra2_rotate_btn', 'extra2_rotation_input');


    // ==========================================
    // 2. TOGGLE UPLOAD vs LINK (RESTORED)
    // ==========================================
    const btnUpload = document.getElementById('btnUploadMethod');
    const btnLink = document.getElementById('btnLinkMethod');
    const sectionUpload = document.getElementById('uploadInputSection');
    const sectionLink = document.getElementById('linkInputSection');
    const fileInput = document.getElementById('main_file_input');
    const imageTempPath = document.getElementById('imageTempPath');

    btnUpload.addEventListener('click', () => {
        btnUpload.classList.add('active');
        btnLink.classList.remove('active');
        sectionUpload.style.display = 'block';
        sectionLink.style.display = 'none';
        imageTempPath.value = ''; // Clear link path if switching back to file
    });

    btnLink.addEventListener('click', () => {
        btnLink.classList.add('active');
        btnUpload.classList.remove('active');
        sectionLink.style.display = 'block';
        sectionUpload.style.display = 'none';
        fileInput.value = ''; // Clear file input if switching to link
    });


    // ==========================================
    // 3. AJAX LINK PULLER (RESTORED)
    // ==========================================
    const btnPull = document.getElementById('btnPullImage');
    const urlInput = document.getElementById('urlInput');
    const pullLoading = document.getElementById('pullLoading');
    const pullError = document.getElementById('pullError');
    // We reuse main_preview_img for the result

    btnPull.addEventListener('click', function() {
        const url = urlInput.value;
        if(!url) return;

        pullLoading.style.display = 'block';
        pullError.style.display = 'none';
        btnPull.disabled = true;

        fetch('{{ route("artworks.preview") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ url: url })
        })
        .then(response => response.json())
        .then(data => {
            pullLoading.style.display = 'none';
            btnPull.disabled = false;

            if(data.success) {
                // Update the shared Main Preview with the pulled image
                document.getElementById('main_preview_img').src = data.preview_url;
                
                // Store the temp path for the backend
                imageTempPath.value = data.temp_path; 
                
                // Reset rotation
                document.getElementById('main_rotation_input').value = 0;
                document.getElementById('main_preview_img').style.transform = 'rotate(0deg)';
            } else {
                pullError.innerText = data.error || 'Failed to fetch image.';
                pullError.style.display = 'block';
            }
        })
        .catch(error => {
            console.error(error);
            pullLoading.style.display = 'none';
            btnPull.disabled = false;
            pullError.innerText = 'System error. Please verify the link.';
            pullError.style.display = 'block';
        });
    });


    // ==========================================
    // 4. CATEGORY & PROMO LOGIC (Standard)
    // ==========================================
    const catSelect = document.getElementById('categorySelect');
    const extraSection = document.getElementById('extraImagesSection');

    function toggleExtras() {
        if (catSelect.value === 'Craft') extraSection.style.display = 'block';
        else extraSection.style.display = 'none';
    }
    catSelect.addEventListener('change', toggleExtras);

    // Promo Calculator
    const promoCheckbox = document.getElementById('is_promo');
    const promoWrapper = document.getElementById('promo_price_wrapper');
    const basePriceInput = document.getElementById('basePrice');
    const discountInput = document.getElementById('discountPercent');
    const promoPriceInput = document.getElementById('promoPrice');

    promoCheckbox.addEventListener('change', function() {
        promoWrapper.style.display = this.checked ? 'block' : 'none';
    });

    function calculateFromPercent() {
        const price = parseFloat(basePriceInput.value) || 0;
        const percent = parseFloat(discountInput.value) || 0;
        if (price > 0) {
            const final = price - (price * (percent / 100));
            promoPriceInput.value = Math.round(final);
        }
    }

    function calculateFromPrice() {
        const price = parseFloat(basePriceInput.value) || 0;
        const promo = parseFloat(promoPriceInput.value) || 0;
        if (price > 0 && promo > 0 && promo < price) {
            const percent = ((price - promo) / price) * 100;
            discountInput.value = Math.round(percent);
        }
    }

    discountInput.addEventListener('input', calculateFromPercent);
    promoPriceInput.addEventListener('input', calculateFromPrice);
    basePriceInput.addEventListener('input', function() {
        if(discountInput.value && promoCheckbox.checked) calculateFromPercent();
    });

    // Init Logic
    if(basePriceInput.value && promoPriceInput.value && promoCheckbox.checked) {
        calculateFromPrice();
    }
</script>
@endpush
@endsection