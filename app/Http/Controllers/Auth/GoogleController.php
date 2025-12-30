<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {

        $googleUser = Socialite::driver('google')->stateless()->user();
        // Find or create a user in your database
        $user = User::firstOrCreate([
            'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(16)), // create a random password
                'role' => 'guest',
           
            ]);

        // Log the user in
        Auth::login($user, true);

        // Redirect to your desired location
        return redirect()->route('dashboard'); // Change 'home' to your route
    }
}
