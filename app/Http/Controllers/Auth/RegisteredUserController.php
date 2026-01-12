<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ArtistProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $slug = Str::slug($request->name) . '-' . Str::lower(Str::random(4));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'slug' => $slug,
            'is_artist' => true,
        ]);

        ArtistProfile::create(['user_id' => $user->id]);

        // 1. Fire the Event (Sends the email)
        event(new Registered($user));

        // 2. Log them in
        Auth::login($user);

        // 3. FORCE REDIRECT TO VERIFY PAGE
        // Use 'verification.notice' which is the standard name for verify-email.blade.php
        return redirect(route('verification.notice')); 
    }
}