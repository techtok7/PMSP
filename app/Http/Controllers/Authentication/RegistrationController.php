<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\Register\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        return view('modules.authentication.register.login.index');
    }

    public function store(StoreRegisterRequest $request)
    {
        try {
            $userDetails = $request->validated();

            $user = User::create($userDetails);

            Auth::login($user);

            return response()->redirect(route('dashboard'))->withSuccess("Regster success");
        } catch (\Throwable $th) {
            return back()->withError("Something went wrong!");
        }
    }
}
