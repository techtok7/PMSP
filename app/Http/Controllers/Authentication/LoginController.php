<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\Login\StoreAuthenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('modules.authentication.login.index');
    }

    public function authenticate(StoreAuthenticate $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            return redirect()->intended(route('dashboard'))->withSuccess(
                'You have successfully logged in.',
            );
        }

        return back()->withError(
            'The provided credentials do not match our records.',
        );
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('login')->withSuccess(
            'You have successfully logged out.',
        );
    }
}
