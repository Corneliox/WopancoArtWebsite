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
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Upload New Artwork</h3>
                        <a href="{{ route('artworks.index') }}" class="btn custom-btn custom-border-btn btn-sm">Back to Dashboard</a>
                    </div>

                    <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" id="artworkForm">
                        @csrf

                        @if(isset($targetUserId) && $targetUserId)
                            <input type="hidden" name="behalf_user_id" value="{{ $targetUserId }}">
                            <div class="alert alert-warning">
                                <strong>Admin Notice:</strong> You are adding this for User ID: {{ $targetUserId }}
                            </div>
                        @endif

                        {{-- 1. BASIC INFO --}}
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" id="categorySelect" class="form-select" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="Lukisan" {{ old('category') == 'Lukisan' ? 'selected' : '' }}>Lukisan (1 Image Max)</option>
                                <option value="Craft" {{ old('category') == 'Craft' ? 'selected' : '' }}>Craft (Max 3 Images)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <hr class="my-4">

                        {{-- 2. MAIN IMAGE --}}
                        <label class="form-label fw-bold">Main Artwork Image <span class="text-danger">*</span></label>
                        
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

                        {{-- Main: Standard File Upload --}}
                        <div id="uploadInputSection">
                            {{-- Preview Container --}}
                            <div class="mb-3 text-center p-3 bg-light border rounded position-relative" id="main_preview_container" style="display:none;">
                                <img id="main_preview_img" src="#" class="img-fluid rounded shadow-sm" style="max-height: 300px; transition: transform 0.3s ease;">
                                <button type="button" id="main_rotate_btn" class="btn btn-dark btn-sm position-absolute bottom-0 end-0 m-3 shadow" title="Rotate 90° Right">
                                    <i class="bi-arrow-clockwise"></i> Rotate
                                </button>
                            </div>

                            <input type="file" name="image" id="main_file_input" class="form-control" accept="image/*">
                            <input type="hidden" name="rotation" id="main_rotation_input" value="0">
                            <small class="text-muted">Max size: 5MB</small>
                        </div>

                        {{-- Main: Link Upload (Keep existing logic) --}}
                        <div id="linkInputSection" style="display: none;">
                            {{-- ... (Keep your existing Link Puller HTML here) ... --}}
                            <label class="form-label small text-muted">Paste a direct link or a Google Drive sharing link</label>
                            <div class="input-group mb-2">
                                <input type="text" id="urlInput" class="form-control" placeholder="https://drive.google.com/file/d/...">
                                <button type="button" class="btn btn-dark" id="btnPullImage">
                                    <i class="bi-cloud-download me-1"></i> Pull Image
                                </button>
                            </div>
                            <div id="pullLoading" class="text-center text-primary mt-2" style="display:none;">
                                <div class="spinner-border spinner-border-sm" role="status"></div> Processing link...
                            </div>
                            <div id="previewArea" class="mt-3 text-center border rounded p-2 bg-light" style="display:none;">
                                <p class="text-success small mb-1"><i class="bi-check-circle"></i> Image pulled successfully!</p>
                                <img id="previewImg" src="" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                <input type="hidden" name="image_temp_path" id="imageTempPath">
                            </div>
                            <div id="pullError" class="text-danger small mt-2" style="display:none;"></div>
                        </div>

                        @error('image') <p class="text-danger mt-1">{{ $message }}</p> @enderror

                        {{-- NEW: EXTRA IMAGES (Separate Inputs for Preview) --}}
                        <div id="extraImagesSection" class="mt-4 p-4 bg-light border rounded" style="display: none;">
                            <label class="form-label fw-bold text-primary mb-3">Additional Craft Images (Optional)</label>
                            
                            {{-- Extra Image 1 --}}
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <label class="form-label small fw-bold">Extra Image #1</label>
                                    
                                    {{-- Preview 1 --}}
                                    <div class="mb-2 text-center p-2 bg-white border rounded position-relative" id="extra1_preview_container" style="display:none;">
                                        <img id="extra1_preview_img" src="#" class="img-fluid rounded" style="max-height: 200px; transition: transform 0.3s ease;">
                                        <button type="button" id="extra1_rotate_btn" class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-2 shadow">
                                            <i class="bi-arrow-clockwise"></i>
                                        </button>
                                    </div>

                                    <input type="file" name="extra_images[0]" id="extra1_file_input" class="form-control form-control-sm" accept="image/*">
                                    <input type="hidden" name="extra_rotations[0]" id="extra1_rotation_input" value="0">
                                </div>
                            </div>

                            {{-- Extra Image 2 --}}
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <label class="form-label small fw-bold">Extra Image #2</label>
                                    
                                    {{-- Preview 2 --}}
                                    <div class="mb-2 text-center p-2 bg-white border rounded position-relative" id="extra2_preview_container" style="display:none;">
                                        <img id="extra2_preview_img" src="#" class="img-fluid rounded" style="max-height: 200px; transition: transform 0.3s ease;">
                                        <button type="button" id="extra2_rotate_btn" class="btn btn-secondary btn-sm position-absolute bottom-0 end-0 m-2 shadow">
                                            <i class="bi-arrow-clockwise"></i>
                                        </button>
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
                                <input type="number" id="basePrice" name="price" class="form-control" placeholder="Optional" value="{{ old('price') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', 1) }}">
                            </div>
                        </div>

                        {{-- Promo Settings --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_promo" name="is_promo" value="1" {{ old('is_promo') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_promo">Enable Promo / Discount?</label>
                        </div>

                        <div class="mb-4 p-3 border rounded bg-light" id="promo_price_wrapper" style="display:none;">
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
                                    <input type="number" id="promoPrice" name="promo_price" class="form-control" value="{{ old('promo_price') }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn custom-btn w-100 mt-3">Upload Artwork</button>
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
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.style.display = 'block';
                    
                    // Reset
                    currentRotation = 0;
                    rotInput.value = 0;
                    img.style.transform = 'rotate(0deg)';
                }
                reader.readAsDataURL(file);
            } else {
                container.style.display = 'none';
            }
        });

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

    // Initialize for MAIN Image
    setupImagePreview('main_file_input', 'main_preview_container', 'main_preview_img', 'main_rotate_btn', 'main_rotation_input');

    // Initialize for EXTRA Image 1
    setupImagePreview('extra1_file_input', 'extra1_preview_container', 'extra1_preview_img', 'extra1_rotate_btn', 'extra1_rotation_input');

    // Initialize for EXTRA Image 2
    setupImagePreview('extra2_file_input', 'extra2_preview_container', 'extra2_preview_img', 'extra2_rotate_btn', 'extra2_rotation_input');


    // ===============================
    // 2. TOGGLE UPLOAD VS LINK (Main Only)
    // ===============================
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
        imageTempPath.value = ''; 
    });

    btnLink.addEventListener('click', () => {
        btnLink.classList.add('active');
        btnUpload.classList.remove('active');
        sectionLink.style.display = 'block';
        sectionUpload.style.display = 'none';
        fileInput.value = ''; 
    });

    // ===============================
    // 3. CATEGORY LISTENER (Show Extras)
    // ===============================
    const catSelect = document.getElementById('categorySelect');
    const extraSection = document.getElementById('extraImagesSection');

    function toggleExtras() {
        if (catSelect.value === 'Craft') {
            extraSection.style.display = 'block';
        } else {
            extraSection.style.display = 'none';
        }
    }
    catSelect.addEventListener('change', toggleExtras);
    toggleExtras(); 

    // ===============================
    // 4. AJAX PULL LOGIC (Main Only)
    // ===============================
    const btnPull = document.getElementById('btnPullImage');
    const urlInput = document.getElementById('urlInput');
    const pullLoading = document.getElementById('pullLoading');
    const previewArea = document.getElementById('previewArea');
    const previewImg = document.getElementById('previewImg');
    const pullError = document.getElementById('pullError');

    btnPull.addEventListener('click', function() {
        const url = urlInput.value;
        if(!url) return;

        pullLoading.style.display = 'block';
        pullError.style.display = 'none';
        previewArea.style.display = 'none';
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
                previewImg.src = data.preview_url;
                imageTempPath.value = data.temp_path; 
                previewArea.style.display = 'block';
            } else {
                pullError.innerText = data.error || 'Failed.';
                pullError.style.display = 'block';
            }
        })
        .catch(error => {
            pullLoading.style.display = 'none';
            btnPull.disabled = false;
            pullError.innerText = 'Error processing link.';
            pullError.style.display = 'block';
        });
    });

    // ===============================
    // 5. PROMO CALCULATOR
    // ===============================
    const promoCheckbox = document.getElementById('is_promo');
    const promoWrapper = document.getElementById('promo_price_wrapper');
    const basePriceInput = document.getElementById('basePrice');
    const discountInput = document.getElementById('discountPercent');
    const promoPriceInput = document.getElementById('promoPrice');

    function togglePromo() {
        promoWrapper.style.display = promoCheckbox.checked ? 'block' : 'none';
    }
    promoCheckbox.addEventListener('change', togglePromo);
    togglePromo(); 

    function calculateFromPercent() {
        const price = parseFloat(basePriceInput.value) || 0;
        const percent = parseFloat(discountInput.value) || 0;
        if (price > 0) {
            const finalPrice = price - (price * (percent / 100));
            promoPriceInput.value = Math.round(finalPrice);
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
</script>
@endpush
@endsection