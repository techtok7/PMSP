<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Mail\VerificationOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        return view('modules.authentication.verification.index');
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $mailable = new VerificationOtp($user->name, $user->otp);

        SendMail::dispatch($user->email, $mailable);

        return back()->withSuccess("OTP sent to your email.");
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

            return redirect()->route('dashboard')->withSuccess("Email verified successfully");
        }

        return back()->withError("Invalid OTP");
    }
}
