<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'WOPANCO') }} - Auth</title>
        
        {{-- FAVICON --}}
        <link rel="icon" sizes="96x96" type="image/png" href="{{ asset('images/wopanco2.png') }}">
        
        {{-- 1. LOAD BOOTSTRAP STYLES (For Header/Footer) --}}
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('css/templatemo-topic-listing.css') }}" rel="stylesheet">      

        {{-- 2. LOAD VITE (For Login Form Styling - Tailwind) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- CUSTOM NAVBAR STYLES (From your main.blade.php) --}}
        <style>
            /* Force Navbar to be visible on white background for Auth pages */
            .navbar {
                background-color: var(--secondary-color) !important; /* Teal Background */
                position: relative !important; /* Not absolute/floating */
            }
            /* ... (Keep your other navbar styles if needed, but the bg change above is crucial) ... */
            
            /* wrapper for the auth card to center it nicely below header */
            #auth-wrapper {
                min-height: 80vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 50px 0;
                background-color: #f3f4f6; /* Light gray background */
            }
        </style>
    </head>
    
    <body id="top">

        <main>
            {{-- === HEADER (COPIED FROM MAIN.BLADE.PHP) === --}}
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('images/wopanco2.png') }}" style="max-width:35px">
                        <span>WOPANCO</span>
                    </a>

                    <div class="d-lg-none ms-auto me-3">
                        {{-- Mobile Spacer --}}
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-5 me-lg-auto">
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('creative') }}">Creative</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('event') }}">Event</a></li>
                        </ul>
                    </div>
                </div>
            </nav>    
        
            {{-- === CONTENT AREA (THE LOGIN/REGISTER FORM) === --}}
            <div id="auth-wrapper">
                {{-- This slot is where login.blade.php content goes --}}
                {{ $slot }}
            </div>
            
        </main>

        {{-- === FOOTER (COPIED FROM MAIN.BLADE.PHP) === --}}
        <footer class="site-footer section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="text-white mb-0">Copyright © 2025 Woman Painter Community</p>
                    </div>
                </div>
            </div>
        </footer>

        {{-- SCRIPTS --}}
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>

    </body>
</html>