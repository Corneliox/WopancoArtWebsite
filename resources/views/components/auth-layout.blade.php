@extends('layouts.main')

{{-- 1. INJECT TAILWIND & CUSTOM STYLES --}}
@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* --- NAVBAR FIX --- */
        /* Forces the navbar to be Teal immediately so links are visible */
        .navbar {
            background-color: var(--secondary-color) !important;
            position: fixed !important;
            top: 0; 
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Reset Body Padding for the Fixed Navbar */
        body { 
            padding-top: 80px !important; 
            background-color: #f3f4f6; /* Light Gray Background for the whole page */
        }

        /* --- FORM CONTAINER STYLE --- */
        /* This ensures the white box looks like a card even if Tailwind fails */
        .auth-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        /* Fix Bootstrap overriding Tailwind inputs */
        .auth-card input {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #374151;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('content')
    {{-- 2. CENTERED WRAPPER --}}
    <div class="d-flex align-items-center justify-content-center" style="min-height: 80vh; padding: 20px;">
        
        {{-- 3. THE FORM SLOT --}}
        <div class="auth-card">
            {{ $slot }}
        </div>

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