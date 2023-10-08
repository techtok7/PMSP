<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GoogleService;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->with([
            'access_type' => 'offline',
            'approval_prompt' => 'force',
        ])->scopes([
            Calendar::CALENDAR,
        ])->redirect();
    }

    public function googleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user) {
            if ($user->email !== $googleUser->email) {
                return redirect()->route('login')->with('error', 'Email did not match');
            }
            $user->update([
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            return redirect()->route('dashboard');
        } else {
            $userCheck = User::where('email', $googleUser->email)->first();

            if ($userCheck) {
                $userCheck->update([
                    'google_access_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);

                Auth::login($userCheck);

                return redirect()->route('dashboard');
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_access_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'is_verified' => true,
                ]);

                Auth::login($user);

                return redirect()->route('dashboard');
            }
        }
    }
}
