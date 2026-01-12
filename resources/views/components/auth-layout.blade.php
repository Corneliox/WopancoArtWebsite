@extends('layouts.main')

{{-- 1. INJECT VITE (TAILWIND) & CUSTOM AUTH STYLES --}}
@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* --- NAVBAR FIX --- */
        .navbar {
            background-color: var(--secondary-color) !important;
            position: fixed !important;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        body { padding-top: 0 !important; background-color: #f3f4f6; }

        /* --- AUTH CARD STYLING --- */
        /* Center the layout */
        #auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 80px; /* Space for fixed navbar */
            padding-bottom: 40px;
        }

        /* The White Card */
        #auth-card {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 2rem;
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        /* --- FORM ELEMENTS OVERRIDES (Fixing the messy inputs) --- */
        /* Ensure Inputs look like Tailwind even if Bootstrap fights it */
        #auth-card input[type="text"],
        #auth-card input[type="email"],
        #auth-card input[type="password"] {
            width: 100%;
            border: 1px solid #d1d5db; /* gray-300 */
            border-radius: 0.375rem; /* rounded-md */
            padding: 0.6rem 0.75rem;
            margin-top: 0.25rem;
            font-size: 0.95rem;
            color: #1f2937;
            background-color: #fff;
            transition: all 0.2s;
        }

        /* Focus State (Teal Glow) */
        #auth-card input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(75, 114, 109, 0.2); /* Teal shadow */
        }

        /* Eye Icon Positioning Fix */
        .relative { position: relative; }
        .absolute-icon {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-35%); /* Center vertically */
            color: #9ca3af;
            cursor: pointer;
            z-index: 10;
        }

        /* Buttons & Links */
        #auth-card button {
            background-color: var(--custom-btn-bg-color); /* Red */
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            width: auto;
            transition: background 0.3s;
        }
        #auth-card button:hover {
            background-color: var(--custom-btn-bg-hover-color);
        }
        #auth-card a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
        }
        #auth-card a:hover {
            color: var(--link-hover-color);
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <div id="auth-wrapper">
        {{-- The White Box Container --}}
        <div id="auth-card">
            {{ $slot }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Force Navbar styling immediately
    const nav = document.querySelector('.navbar');
    if(nav) {
        nav.classList.add('mobile-menu-open');
        nav.classList.add('is-sticky');
    }
    // Remove Bottom Nav on Auth Pages
    const bottomNav = document.getElementById('wopanco-bottom-nav');
    if(bottomNav) bottomNav.remove();
</script>
@endpush