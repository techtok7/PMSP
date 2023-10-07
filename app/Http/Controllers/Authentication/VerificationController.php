<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        return view('modules.authentication.verification.index');
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->otp == $request->otp) {
            $user->update([
                'is_verified' => true,
                'otp' => null
            ]);

            return response()->route('dashboard')->withSuccess("Email verified successfully");
        }

        return back()->withError("Invalid OTP");
    }
}
