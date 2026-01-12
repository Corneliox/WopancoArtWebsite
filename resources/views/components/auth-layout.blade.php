@extends('layouts.main')

@push('styles')
<style>
    /* 1. BACKGROUND & CENTERING */
    /* Light gray background for the whole page */
    body {
        background-color: #f8f9fa !important; 
    }
    
    /* Wrapper to center the box vertically and horizontally */
    #auth-wrapper {
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 80px; /* Space for the fixed navbar */
        padding-bottom: 40px;
    }

    /* 2. THE WHITE AUTH BOX */
    .auth-box {
        background-color: #ffffff;
        border-radius: 20px;       /* 20px Corner Radius */
        border: 1px solid #e0e0e0; /* 1px Outline (Light Gray) */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); /* Soft Shadow */
        padding: 40px;
        width: 100%;
        max-width: 500px; /* Keeps it from getting too wide */
    }

    /* 3. NAVBAR OVERRIDES (Force Active State) */
    /* We force the navbar to look like it does when scrolled */
    .navbar {
        background-color: var(--white-color) !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: fixed !important;
        top: 0;
        width: 100%;
        z-index: 1000;
    }

    /* Force Text & Icons to be Teal (Secondary Color) */
    .navbar .nav-link,
    .navbar .navbar-brand span,
    .navbar .bi-cart3,
    .navbar .user-name-text,
    .navbar .bi-person {
        color: var(--secondary-color) !important;
    }

    /* Force Toggler (Hamburger Menu) to be Teal */
    .navbar-toggler {
        border-color: var(--secondary-color) !important;
    }
    .navbar-toggler-icon {
        filter: brightness(0) saturate(100%) invert(36%) sepia(88%) saturate(680%) hue-rotate(200deg) brightness(92%) contrast(92%) !important;
    }

    /* 4. FORM ELEMENT STYLING (Bootstrap Tweaks) */
    .auth-box input[type="text"],
    .auth-box input[type="email"],
    .auth-box input[type="password"] {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #ced4da;
        width: 100%;
        margin-bottom: 15px;
    }
    
    .auth-box input:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 0.2rem rgba(75, 114, 109, 0.25);
        outline: none;
    }

    .auth-box button {
        width: 100%;
        border-radius: 10px;
        padding: 10px;
        font-weight: bold;
        background-color: var(--custom-btn-bg-color);
        color: #fff;
        border: none;
        transition: background 0.3s;
    }
    
    .auth-box button:hover {
        background-color: var(--custom-btn-bg-hover-color);
    }

    /* Eye Icon for Password */
    .password-wrapper {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-65%); /* Adjust vertically */
        cursor: pointer;
        color: #6c757d;
        z-index: 10;
    }
</style>
@endpush

@section('content')
    <div id="auth-wrapper">
        <div class="auth-box">
            {{ $slot }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // 1. Force Navbar Logic
    // Since we used CSS !important above, we just need to ensure 
    // the mobile menu logic doesn't break it.
    document.addEventListener("DOMContentLoaded", function() {
        const nav = document.querySelector('.navbar');
        if(nav) {
            nav.classList.add('is-sticky'); // Triggers existing JS logic if any
        }
    });

    // 2. Remove Bottom Nav on Auth Pages
    const bottomNav = document.getElementById('wopanco-bottom-nav');
    if(bottomNav) bottomNav.remove();
</script>
@endpush