<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth provider
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google OAuth provider
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            return $this->handleSocialUser($user, 'google');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }
    }

    /**
     * Redirect to Apple OAuth provider
     */
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    /**
     * Handle callback from Apple OAuth provider
     */
    public function handleAppleCallback()
    {
        try {
            $user = Socialite::driver('apple')->user();
            return $this->handleSocialUser($user, 'apple');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Apple login failed. Please try again.');
        }
    }

    /**
     * Handle social user login/registration
     */
    private function handleSocialUser($socialUser, $provider)
    {
        // Find or create user
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?? 'User',
                'email' => $socialUser->getEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt(str()->random(32)), // Random password for social users
            ]);
        }

        // Log the user in
        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
