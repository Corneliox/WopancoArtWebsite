<x-auth-layout>
    {{-- HEADER --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold fs-2" style="color: var(--primary-color);">Confirm Password</h2>
        <p class="text-muted small">
            This is a secure area. Please confirm your password before continuing.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label for="password" class="form-label small fw-bold text-secondary">Password</label>
            <div class="position-relative">
                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control pe-5">
                <i class="bi bi-eye-slash toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #6c757d;" onclick="togglePassword('password', this)"></i>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger small" />
        </div>

        {{-- BUTTON --}}
        <div class="d-grid">
            <button type="submit" class="btn text-white fw-bold py-2" style="background-color: var(--custom-btn-bg-color); border-radius: 10px;">
                Confirm
            </button>
        </div>
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
