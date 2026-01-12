<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'WOPANCO') }}</title>
        
        {{-- FAVICON --}}
        <link rel="icon" sizes="96x96" type="image/png" href="{{ asset('images/wopanco2.png') }}">
        
        {{-- FONTS --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                
        {{-- STYLES: BOOTSTRAP (For Header/Footer) --}}
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('css/templatemo-topic-listing.css') }}" rel="stylesheet">      

        {{-- STYLES: VITE (For Login Form - Tailwind) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- CUSTOM NAVBAR STYLES --}}
        <style>
            /* Force Navbar background for Auth pages (so links are visible) */
            .navbar {
                background-color: var(--secondary-color) !important; /* Teal */
                position: relative !important;
                margin-bottom: 0;
            }
            .navbar-brand span, .nav-link, .bi-person, .bi-cart3 {
                color: #fff !important;
            }
            
            /* Wrapper to center the Auth Card */
            #auth-wrapper {
                min-height: 80vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-color: #f3f4f6; /* Light gray background */
                padding: 40px 15px;
            }

            /* Bottom Nav Mobile Fix */
            .bottom-nav {
                position: fixed;
                left: 50%;
                transform: translateX(-50%);
                bottom: 20px;
                z-index: 9999;
                display: flex;
                gap: 5px;
                background: rgba(30, 30, 30, 0.85);
                backdrop-filter: blur(10px);
                box-shadow: 0 8px 30px rgba(0,0,0,0.3);
                padding: 10px 15px;
                border-radius: 50px;
                min-width: 320px;
                justify-content: space-around;
            }
            .bn-btn {
                display: flex; flex-direction: column; align-items: center;
                color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.75rem;
            }
            .bn-btn.active { color: #fff; }
            .bn-btn .bi { font-size: 1.3rem; margin-bottom: 2px; }
            @media (min-width: 992px) { .bottom-nav { display: none; } }
        </style>
    </head>
    
    <body id="top">

        <main>
            {{-- === HEADER === --}}
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('images/wopanco2.png') }}" style="max-width:35px">
                        <span>WOPANCO</span>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-5 me-lg-auto">
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('creative') }}">Creative</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('event') }}">Event</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About us</a></li>
                        </ul>
                        
                        <div class="d-none d-lg-flex align-items-center ms-auto">
                            <a href="{{ route('login') }}" class="btn custom-btn btn-sm">Login</a>
                        </div>
                    </div>
                </div>
            </nav>    
        
            {{-- === AUTH CONTENT (Login/Register Form) === --}}
            <div id="auth-wrapper">
                {{ $slot }}
            </div>
            
        </main>

        {{-- === FOOTER === --}}
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