@extends('layouts.main')

{{-- 1. INJECT VITE (TAILWIND) & CUSTOM AUTH STYLES --}}
@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* --- 1. NAVBAR FIX --- */
        /* Force Navbar to be Teal so it's visible on the gray background */
        .navbar {
            background-color: var(--secondary-color) !important;
            position: fixed !important;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        body { padding-top: 0 !important; }

        /* --- 2. AUTH THEME OVERRIDES (Using your :root vars) --- */
        #auth-wrapper {
            background-color: #f3f4f6; /* Light Gray Background */
        }

        /* CARD HEADER */
        #auth-card h2 {
            color: var(--primary-color) !important; /* Dark Red Title */
            font-family: var(--title-font-family);
        }

        /* BUTTONS (Login / Register) */
        #auth-card button[type="submit"] {
            background-color: var(--custom-btn-bg-color) !important; /* Red Button */
            color: var(--white-color) !important;
            transition: background-color 0.3s;
        }
        #auth-card button[type="submit"]:hover {
            background-color: var(--custom-btn-bg-hover-color) !important; /* Darker Red Hover */
        }

        /* INPUTS (Focus State) */
        #auth-card input:focus, 
        #auth-card textarea:focus {
            border-color: var(--secondary-color) !important; /* Teal Border */
            --tw-ring-color: var(--secondary-color) !important; /* Teal Ring */
            box-shadow: 0 0 0 1px var(--secondary-color) !important;
        }

        /* LINKS (Forgot Password, etc.) */
        #auth-card a {
            color: var(--secondary-color);
            transition: color 0.2s;
        }
        #auth-card a:hover {
            color: var(--link-hover-color); /* Red on Hover */
        }
    </style>
@endpush

@section('content')
    {{-- 2. CENTERED WRAPPER --}}
    <div id="auth-wrapper" style="
        min-height: 100vh; 
        width: 100%;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        padding-top: 80px; 
        padding-bottom: 40px;
    ">
        
        {{-- 3. FORM CONTAINER (The White Box) --}}
        <div id="auth-card" style="width: 100%; max-width: 450px; padding: 0 15px;">
            {{ $slot }}
        </div>

    </div>
@endsection

{{-- 3. JAVASCRIPT LOGIC --}}
@push('scripts')
<script>
    // Force Navbar to appear "Active" immediately
    const nav = document.querySelector('.navbar');
    if(nav) {
        nav.classList.add('mobile-menu-open');
        nav.classList.add('is-sticky');
    }

    // Remove Bottom Nav on Auth Pages (Distracting)
    const bottomNav = document.getElementById('wopanco-bottom-nav');
    if(bottomNav) bottomNav.remove();

    // Disable Body Scroll on Desktop (Cleaner look)
    if (window.innerWidth >= 992) {
        document.body.style.overflow = 'hidden';
    }
</script>
@endpush