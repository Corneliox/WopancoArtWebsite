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

        /* ============================= */
        /* GOD-TIER AUTH CARD CONTAINER  */
        /* ============================= */
        .auth-card {
            background: #ffffff;

            /* God-tier rounded corners */
            border-radius: 20px;

            /* Elegant outline */
            border: 1px solid rgba(0, 0, 0, 0.06);

            /* Soft premium shadow (layered) */
            box-shadow:
                0 10px 25px -5px rgba(0, 0, 0, 0.08),
                0 4px 10px -4px rgba(0, 0, 0, 0.06);

            padding: 2.25rem;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;

            /* Smooth visual polish */
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }

        /* Subtle hover lift (desktop only) */
        @media (hover: hover) {
            .auth-card:hover {
                transform: translateY(-2px);
                box-shadow:
                    0 16px 35px -8px rgba(0, 0, 0, 0.12),
                    0 6px 15px -6px rgba(0, 0, 0, 0.08);
            }
        }

        /* ============================= */
        /* INPUT FIX (BOOTSTRAP SAFE)    */
        /* ============================= */
        .auth-card input {
            display: block;
            width: 100%;
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
            line-height: 1.5;
            color: #374151;

            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;

            margin-bottom: 1rem;

            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        /* Focus state = premium */
        .auth-card input:focus {
            outline: none;
            border-color: #6366f1; /* Indigo */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
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