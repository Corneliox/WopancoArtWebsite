@extends('layouts.main')

@section('content')

<style>
/* ============================= */
/* AUTH PAGE ONLY — SCOPED CSS   */
/* ============================= */

.auth-page {
    background-color: #f3f4f6;
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* AUTH CARD */
.auth-card {
    background: #ffffff;
    padding: 2rem;
    border-radius: 12px;

    /* Visible outline */
    border: 1px solid rgba(0, 0, 0, 0.12);

    /* Premium shadow */
    box-shadow:
        0 0 0 1px rgba(0, 0, 0, 0.04),
        0 10px 25px -8px rgba(0, 0, 0, 0.15),
        0 4px 10px -6px rgba(0, 0, 0, 0.10);

    width: 100%;
    max-width: 450px;
}

/* INPUT SAFETY */
.auth-card input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
}
</style>

<div class="auth-page">
    <div class="auth-card">
        {{ $slot }}
    </div>
</div>

<script>
    // Disable scroll ONLY on auth pages (desktop)
    if (window.innerWidth >= 992) {
        document.body.style.overflow = 'hidden';
    }
</script>

@endsection
