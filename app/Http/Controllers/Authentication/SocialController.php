<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Services\GoogleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function googleRedirect()
    {
        $googlService = new GoogleService();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->google_access_token) {
            $url = $googlService->getAuthUrl();

            return redirect($url);
        }

        $googlService->setAccessToken($user->google_access_token);

        $googlService->setRefreshToken($user->google_refresh_token);

        $googlService->profile();
    }

    public function googleCallback(Request $request)
    {
        $googlService = new GoogleService();

        $tokens = $googlService->fetchAccessTokenWithAuthCode($request->code);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'google_access_token' => $tokens['access_token'],
            'google_refresh_token' => $tokens['refresh_token'],
        ]);

        $accessToken = $googlService->getAccessToken();

        $refreshToken = $googlService->getRefreshToken();

        $userInfo = $googlService->userInfo();

        dd($accessToken, $refreshToken, $userInfo);

        return view('google', compact('client', 'calendar', 'calendarId', 'accessToken', 'refreshToken', 'scopes', 'status'));
    }
}
