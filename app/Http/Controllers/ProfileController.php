<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile() {
        $user = Auth::user();
        return view('modules.user.profile')->with('user',$user);
    }

    public function profile_update(UpdateProfileRequest $request) {
        $userData = $request->validated();
        $user = User::find(Auth::id());
        $user->update(["name"=>$userData["name"], "email"=>$userData['email']]);

        return redirect()->back()->withSuccess('Data updated successfully');
    }
}
