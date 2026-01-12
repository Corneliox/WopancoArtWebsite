@extends('layouts.main')

@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ============================= */
        /* NAVBAR (FORCED VISIBLE STATE) */
        /* ============================= */
        .navbar {
            position: fixed !important;
            top: 0;
            width: 100%;
            z-index: 1000;

            background-color: var(--secondary-color) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        body {
            padding-top: 80px !important;
            background-color: #f3f4f6;
        }

        /* ============================= */
        /* AUTH CARD (PREMIUM CONTAINER) */
        /* ============================= */
        .auth-card {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            padding: 2.25rem;

            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.06);

            box-shadow:
                0 10px 25px -5px rgba(0, 0, 0, 0.08),
                0 4px 10px -4px rgba(0, 0, 0, 0.06);

            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        @media (hover: hover) {
            .auth-card:hover {
                transform: translateY(-2px);
                box-shadow:
                    0 16px 35px -8px rgba(0, 0, 0, 0.12),
                    0 6px 15px -6px rgba(0, 0, 0, 0.08);
            }
        }

        /* ============================= */
        /* INPUT NORMALIZATION (SAFE)    */
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

        .auth-card input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
    </style>
@endpush

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 px-3">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Remove bottom navigation on auth pages
        const bottomNav = document.getElementById('wopanco-bottom-nav');
        if (bottomNav) bottomNav.remove();

        // Force navbar into visible/sticky state
        const nav = document.querySelector('.navbar');
        if (nav) {
            nav.classList.add('mobile-menu-open', 'is-sticky');
        }

        // Disable scroll ONLY on desktop auth pages
        if (window.matchMedia('(min-width: 992px)').matches) {
            document.body.style.overflow = 'hidden';
        }
    });
</script>
@endpush
