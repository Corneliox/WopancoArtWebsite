<x-auth-layout>
    {{-- HEADER --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold fs-2" style="color: var(--primary-color);">Register</h2>
        <p class="text-muted small">Create a new account.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- NAME --}}
        <div class="mb-3">
            <label for="name" class="form-label small fw-bold text-secondary">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-control">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-danger small" />
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label for="email" class="form-label small fw-bold text-secondary">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-control">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger small" />
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <label for="password" class="form-label small fw-bold text-secondary">Password</label>
            <div class="position-relative">
                <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control pe-5">
                
                {{-- Eye Icon --}}
                <i id="reg-eye-1" class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', 'reg-eye-1')"></i>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger small" />
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label small fw-bold text-secondary">Confirm Password</label>
            <div class="position-relative">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control pe-5">
                
                {{-- Eye Icon --}}
                <i id="reg-eye-2" class="bi bi-eye-slash toggle-password" onclick="togglePassword('password_confirmation', 'reg-eye-2')"></i>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-danger small" />
        </div>

        {{-- LINKS & BUTTON --}}
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mt-4 gap-3">
            <a href="{{ route('login') }}" class="small text-decoration-none order-2 order-sm-1" style="color: var(--secondary-color);">
                Already registered?
            </a>

            <button type="submit" class="btn text-white fw-bold py-2 px-4 w-100 w-sm-auto order-1 order-sm-2" style="background-color: var(--custom-btn-bg-color); border-radius: 10px;">
                Register
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
</x-auth-layout>
