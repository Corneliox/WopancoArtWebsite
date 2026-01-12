<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
// use App\Models\ArtistProfile; // <-- Remove or comment this out
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
            'is_artist' => false, // <--- 1. Set to FALSE (Regular User)
        ]);

        // 2. REMOVED: Do not create ArtistProfile here.
        // ArtistProfile::create(['user_id' => $user->id]); 

        // 3. FIX: Manually force the email to send immediately
        // (Bypasses the Event Listener which might be failing)
        $user->sendEmailVerificationNotification(); 
        
        // Optional: You can still fire the event for other listeners (like logs)
        // event(new Registered($user));
        
        // 4. Log them in
        Auth::login($user);

        // 5. Force Redirect to Verify Page
        return redirect(route('verification.notice')); 
    }
}