<?php

namespace App\Http\Controllers;

use App\Services\GoogleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        /**
         * @var \App\Models\User $user
         */
        $user  = Auth::user();

        $googleService = new GoogleService();

        $googleService->setAccessToken($user->google_access_token);

        $googleService->setRefreshToken($user->google_refresh_token);

        dd($googleService->getEvents());
    }
}
