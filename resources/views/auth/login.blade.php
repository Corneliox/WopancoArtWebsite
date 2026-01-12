<x-auth-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: var(--primary-color);">Login</h2>
        <p class="text-muted small">Welcome back! Please login to continue.</p>
    </div>

    <x-auth-session-status class="mb-3 text-success small" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label fw-bold small text-secondary">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label fw-bold small text-secondary">Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" required>
                <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        {{-- Remember Me --}}
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label small text-muted" for="remember_me">Remember me</label>
        </div>

        {{-- Links --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('register') }}" class="small text-decoration-none" style="color: var(--secondary-color);">Register</a>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-decoration-none text-muted">Forgot Password?</a>
            @endif
        </div>

        {{-- Button --}}
        <button type="submit">Log In</button>
    </form>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>
</x-auth-layout>