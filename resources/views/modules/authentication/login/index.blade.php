@extends('layouts.authentication')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('welcome') }}" class="h1"><b>Login</b></a>
            </div>
            <div class="card-body">
                
                <form action="{{ route('authenticate') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append" required>
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="social-auth-links text-center mt-2 mb-3">
                    <a href="#" class="btn btn-block btn-primary">
                         Sign in using Microsoft
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                <p class="mb-1">
                    <a href="{{ route('forgot-password.index') }}">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('register.index') }}" class="text-center">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>
@endsection
