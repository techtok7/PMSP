<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('modules.authentication.login.index');
    }

    public function authenticate(Request $request)
    {
    }
}
