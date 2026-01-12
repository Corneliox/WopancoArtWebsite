<x-auth-layout>
    {{-- THE CONTENT CARD (White Box, Shadow, Radius 20) --}}
    <div class="auth-card">
        
        {{-- HEADER --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold fs-2" style="color: var(--primary-color);">Login</h2>
            <p class="text-muted small">Welcome back! Please login to continue.</p>
        </div>

        <x-auth-session-status class="mb-3" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control">
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger small" />
            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                <div class="position-relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control pe-5">
                    
                    {{-- Eye Icon --}}
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" 
                          style="cursor: pointer;"
                          onclick="togglePassword('password', 'login-eye')">
                        <i id="login-eye" class="bi bi-eye-slash text-secondary fs-5"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger small" />
            </div>

            {{-- REMEMBER ME --}}
            <div class="mb-3 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label small text-muted">Remember me</label>
            </div>

            {{-- LINKS --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('register') }}" class="small text-decoration-none" style="color: var(--secondary-color);">
                    Register Account
                </a>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small text-decoration-none text-muted">
                        Forgot Password?
                    </a>
                @endif
            </div>

            {{-- BUTTON --}}
            <div class="d-grid">
                <button type="submit" class="btn text-white fw-bold py-2" style="background-color: var(--custom-btn-bg-color); border-radius: 10px;">
                    Log In
                </button>
            </div>
        </form>

        <script>
            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                } else {
                    input.type = "password";
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                }
            }
        </script>
    </div>
</x-auth-layout>