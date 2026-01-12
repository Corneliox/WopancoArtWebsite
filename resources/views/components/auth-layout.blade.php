{{-- This is a Blade COMPONENT, not a full HTML document --}}
@extends('layouts.main')

@section('content')
    <div
        id="auth-wrapper"
        class="flex items-center justify-center px-4 py-16"
        style="min-height: 80vh; background:#f3f4f6;"
    >
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>
@endsection
