<x-auth-layout>
    {{-- HEADER --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold fs-2" style="color: var(--primary-color);">Verify Email</h2>
        <p class="text-muted small">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small mb-4" role="alert">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <div class="d-flex flex-column gap-3">
        {{-- Resend Button --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="d-grid">
                <button type="submit" class="btn text-white fw-bold py-2" style="background-color: var(--custom-btn-bg-color); border-radius: 10px;">
                    Resend Verification Email
                </button>
            </div>
        </form>

        {{-- Log Out Link --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="text-center">
                <button type="submit" class="btn btn-link text-decoration-none text-muted small">
                    Log Out
                </button>
            </div>
        </form>
    </div>
</x-auth-layout>
