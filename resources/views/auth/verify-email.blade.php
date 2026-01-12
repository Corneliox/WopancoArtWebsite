<x-auth-layout>
    {{-- CONTENT CARD --}}
    {{-- HEADER --}}
    <div class="text-center mb-4">
        <i class="bi bi-envelope-check text-primary" style="font-size: 3rem;"></i>
        <h2 class="fw-bold fs-2 mt-2" style="color: var(--primary-color);">Verify Email</h2>
        <p class="text-muted small">
            We've sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
        </p>
    </div>

    {{-- STATUS MESSAGE --}}
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small mb-4 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> A new link has been sent to your email!
        </div>
    @endif

    {{-- SPAM WARNING --}}
    <div class="alert alert-warning small mb-4 d-flex align-items-start shadow-sm border-0" style="background-color: #fff3cd; color: #856404;">
        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
        <div>
            <strong>Can't find the email?</strong><br>
            Please check your <u>Spam</u> or <u>Junk</u> folder. It often ends up there!
        </div>
    </div>

    {{-- ACTIONS --}}
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

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="text-center">
                <button type="submit" class="btn btn-link text-decoration-none text-muted small">
                    Log Out / Change Email
                </button>
            </div>
        </form>
    </div>

    {{-- AUTO-DETECT SCRIPT --}}
    <div class="text-center mt-4">
        <span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>
        <small class="text-muted ms-2">Waiting for verification...</small>
    </div>


    {{-- POLLING SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check status every 3 seconds
            setInterval(function() {
                fetch('{{ route("verification.check") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.verified) {
                        // If verified, reload page to let Laravel redirect them to Home
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error checking verification:', error));
            }, 3000);
        });
    </script>
</x-auth-layout>