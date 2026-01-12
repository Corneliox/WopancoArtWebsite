@extends('layouts.main')

@section('content')
    <div
        id="auth-wrapper"
        class="flex items-center justify-center px-4"
        style="min-height: calc(100vh - 140px); background:#f3f4f6;"
    >
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // 1. Disable scroll on desktop
    if (window.innerWidth >= 992) {
        document.body.style.overflow = 'hidden';
    }

    // 2. Force navbar highlighted state
    document.querySelector('.navbar')?.classList.add('mobile-menu-open');

    // 3. Remove bottom nav
    document.getElementById('wopanco-bottom-nav')?.remove();
</script>
@endpush
