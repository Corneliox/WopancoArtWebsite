<x-auth-layout>
{{-- HEADER --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold fs-2" style="color: var(--primary-color);">Forgot Password?</h2>
        <p class="text-muted small">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </p>
    </div>

    {{-- SESSION STATUS (Success Message) --}}
    <x-auth-session-status class="mb-3 text-success small text-center fw-bold" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- EMAIL ADDRESS --}}
        <div class="mb-4">
            <label for="email" class="form-label small fw-bold text-secondary">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger small" />
        </div>

        {{-- ACTIONS --}}
        <div class="d-flex flex-column gap-3">
            {{-- Submit Button --}}
            <button type="submit" class="btn text-white fw-bold py-2" style="background-color: var(--custom-btn-bg-color); border-radius: 10px;">
                {{ __('Email Password Reset Link') }}
            </button>

            {{-- Back Link --}}
            <div class="text-center">
                <a href="{{ route('login') }}" class="small text-decoration-none fw-bold" style="color: var(--secondary-color);">
                    <i class="bi bi-arrow-left me-1"></i> {{ __('Back to Login') }}
                </a>
            </div>
        </div>
    </form>
</x-auth-layout>
