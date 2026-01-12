@extends('layouts.main')

@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* 1. PAGE BACKGROUND & CENTERING */
        body {
            background-color: #f8f9fa !important; 
        }
        
        #auth-wrapper {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 80px; 
            padding-bottom: 40px;
        }

        /* 2. NAVBAR OVERRIDES */
        .navbar {
            background-color: var(--secondary-color) !important;
            position: fixed !important;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Force Text Colors for Visibility */
        .navbar .nav-link, .navbar .navbar-brand span, 
        .navbar .bi-cart3, .navbar .user-name-text, .navbar .bi-person {
            color: #ffffff !important;
        }
        .navbar-toggler { border-color: rgba(255,255,255,0.5) !important; }
        .navbar-toggler-icon { filter: brightness(0) invert(1) !important; }

        /* 3. CONTENT CARD STYLING (To be used in the views) */
        .auth-card {
            background-color: #ffffff;
            border-radius: 20px;       /* 20px Radius */
            border: 1px solid #e5e7eb; /* 1px Outline */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); /* Soft Shadow */
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
        }

        /* Form Inputs override */
        .auth-card input.form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
        }
        .auth-card input.form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(75, 114, 109, 0.25);
        }
    </style>
@endpush

@section('content')
    <div id="auth-wrapper">
        {{-- The Slot contains the Card + Form --}}
        {{ $slot }}
    </div>
@endsection

@push('scripts')
<script>
    // Remove the bottom nav on login pages to reduce clutter
    const bottomNav = document.getElementById('wopanco-bottom-nav');
    if(bottomNav) bottomNav.remove();

    const nav = document.querySelector('.navbar');
    if(nav) {
        nav.classList.add('mobile-menu-open');
        nav.classList.add('is-sticky');
    }

    // Disable Body Scroll on Desktop (Cleaner look)
    if (window.innerWidth >= 992) {
        document.body.style.overflow = 'hidden';
    }
</script>
@endpush