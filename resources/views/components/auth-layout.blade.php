@extends('layouts.main')

{{-- 1. INJECT VITE (TAILWIND) FOR THE FORM --}}
{{-- We push this to the 'styles' stack if your main layout has it, or just include it here --}}
@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Force Navbar to be teal so it's visible on the gray background */
        .navbar {
            background-color: var(--secondary-color) !important;
            position: fixed !important;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        /* Fix Body padding since navbar is fixed */
        body {
            padding-top: 0 !important; 
        }
    </style>
@endpush

@section('content')
    {{-- 2. CENTERED WRAPPER --}}
    {{-- We use inline Flexbox to ensure centering works even if Tailwind loads late --}}
    <div style="
        min-height: 100vh; 
        width: 100%;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        background-color: #f3f4f6; 
        padding-top: 80px; /* Space for fixed navbar */
        padding-bottom: 40px;
    ">
        
        {{-- 3. FORM CONTAINER --}}
        {{-- Constrain width so it doesn't stretch too wide --}}
        <div style="width: 100%; max-width: 450px; padding: 0 15px;">
            {{ $slot }}
        </div>

    </div>
@endsection

{{-- 3. JAVASCRIPT LOGIC --}}
@push('scripts')
<script>
    // 1. Force Navbar to appear "Active/Sticky" immediately
    const nav = document.querySelector('.navbar');
    if(nav) {
        nav.classList.add('mobile-menu-open'); // Forces your white/teal style
        nav.classList.add('is-sticky');
    }

    // 2. Remove Bottom Nav (It's distracting on login pages)
    const bottomNav = document.getElementById('wopanco-bottom-nav');
    if(bottomNav) bottomNav.remove();

    // 3. Disable Body Scroll on Desktop (Optional, gives a focused 'App' feel)
    if (window.innerWidth >= 992) {
        document.body.style.overflow = 'hidden';
    }
</script>
@endpush