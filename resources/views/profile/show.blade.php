@extends('layouts.main')

@push('styles')
<style>
    /* Styling for the Profile Cards */
    .profile-card {
        background: #ffffff;
        padding: 3rem; /* More spacing for wider layout */
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        height: 100%;
        
        /* Ensure it fills the grid column */
        width: 100%;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 0.95rem;
        color: #4B726D; /* Secondary Color */
    }

    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #4B726D;
        box-shadow: 0 0 0 0.2rem rgba(75, 114, 109, 0.25);
    }
    
    /* Section Dividers */
    .section-title {
        color: #81131C;
        font-weight: 700;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
</style>
@endpush

@section('content')

    {{-- 1. HERO SECTION --}}
    <section class="hero-section" style="min-height: 250px;">
        <div class="container">
            <div class="row align-items-center" style="min-height: 250px;">
                <div class="col-12">
                    <h1 class="text-center text-white">Profile Settings</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. SETTINGS FORMS --}}
    <section class="section-padding" style="background-color: #f8f9fa;">
        <div class="container-fluid"> {{-- Changed to container-fluid for full width control --}}
            <div class="row justify-content-center">
                
                {{-- WIDER COLUMN: col-lg-10 is roughly 83% of the screen --}}
                <div class="col-12 col-lg-10">

                    <div class="row g-4">
                        
                        {{-- LEFT COLUMN: Profile & Password (60% on desktop) --}}
                        <div class="col-lg-7 col-12">
                            
                            {{-- A. PROFILE INFORMATION --}}
                            <div class="profile-card mb-4" id="update-profile-information">
                                <h4 class="section-title">Profile Information</h4>
                                
                                <form method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')

                                    {{-- Name --}}
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" name="name" type="text" class="form-control" 
                                               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                        @error('name') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input id="email" name="email" type="email" class="form-control" 
                                               value="{{ old('email', $user->email) }}" required autocomplete="username">
                                        @error('email') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    <div class="d-flex align-items-center">
                                        <button type="submit" class="btn custom-btn px-4">Save Profile</button>
                                        @if (session('status') === 'profile-updated')
                                            <span class="text-success ms-3 small fw-bold"><i class="bi bi-check-circle"></i> Saved.</span>
                                        @endif
                                    </div>
                                </form>
                            </div>

                            {{-- B. UPDATE PASSWORD --}}
                            <div class="profile-card mb-4" id="update-password-information">
                                <h4 class="section-title">Security</h4>
                                <p class="text-muted small mb-4">Ensure your account is using a long, random password to stay secure.</p>

                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                                        @error('current_password', 'updatePassword') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                                            @error('password', 'updatePassword') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                                            @error('password_confirmation', 'updatePassword') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <button type="submit" class="btn custom-btn px-4">Update Password</button>
                                        @if (session('status') === 'password-updated')
                                            <span class="text-success ms-3 small fw-bold"><i class="bi bi-check-circle"></i> Saved.</span>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- RIGHT COLUMN: Artist Profile & Danger Zone (40% on desktop) --}}
                        <div class="col-lg-5 col-12">
                            
                            {{-- C. ARTIST PROFILE CARD (Only if Artist) --}}
                            @if (Auth::user()->is_artist)
                                <div class="profile-card mb-4" id="artist-profile-form" style="border-top: 5px solid #81131C;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="fw-bold mb-0" style="color: #81131C;">Artist Settings</h4>
                                        <span class="badge bg-primary">Artist</span>
                                    </div>
                                    <hr>

                                    <form method="post" action="{{ route('artist.profile.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')

                                        {{-- Picture --}}
                                        <div class="text-center mb-4">
                                            @if ($profile->profile_picture)
                                                <img src="{{ Storage::url($profile->profile_picture) }}" class="rounded-circle shadow-sm border mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('images/topics/undraw_happy_music_g6wc.png') }}" class="rounded-circle shadow-sm border mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                                            @endif
                                            
                                            <input class="form-control form-control-sm" type="file" id="profile_picture" name="profile_picture" accept="image/*">
                                            @error('profile_picture') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- About (Rich Editor) --}}
                                        <div class="mb-4">
                                            <label for="about" class="form-label">About Me (Bio)</label>
                                            <textarea class="form-control rich-editor" id="about" name="about" style="height: 150px;">{{ old('about', $profile->about) }}</textarea>
                                            @error('about') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn custom-btn">Save Artist Profile</button>
                                            <a href="{{ route('artworks.index') }}" class="btn btn-outline-dark">Manage My Artworks <i class="bi-arrow-right"></i></a>
                                        </div>

                                        @if (session('status') === 'artist-profile-updated')
                                            <div class="mt-3 text-success small fw-bold text-center"><i class="bi bi-check-circle"></i> Profile Updated!</div>
                                        @endif
                                    </form>
                                </div>
                            @endif

                            {{-- D. DELETE ACCOUNT CARD --}}
                            <div class="profile-card" style="border: 1px solid #dc3545;">
                                <h4 class="mb-3 text-danger fw-bold">Delete Account</h4>
                                <p class="text-muted small">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                                
                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                                    Delete Account
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title text-danger fw-bold">Are you sure?</h5>
                    </div>
                    <div class="modal-body p-0 mb-3">
                        <p class="small text-muted">Please enter your password to confirm you would like to permanently delete your account.</p>
                        <input id="password_delete" name="password" type="password" class="form-control" placeholder="Current Password">
                        @error('password', 'userDeletion') <p class="text-danger small mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="modal-footer border-0 p-0">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Smooth Scroll to specific sections
    window.addEventListener('load', function() {
        if (window.location.hash) {
            setTimeout(function() {
                try {
                    var element = document.querySelector(window.location.hash);
                    if (element) {
                        var headerOffset = 100; 
                        var elementPosition = element.getBoundingClientRect().top;
                        var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                    }
                } catch(e) {}
            }, 300);
        }
    });
</script>
@endpush