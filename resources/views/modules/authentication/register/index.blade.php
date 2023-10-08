@extends('layouts.authentication')

@section('content')
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('dashboard') }}" class="h1"><b>Register</b></a>
            </div>
            <div class="card-body">
                
                <form action="{{ route('register.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Full name">
                        <div class="input-group-append" required>
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        <div class="input-group-append" required>
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append" required>
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                            placeholder="Confirm password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block">Not sign in?  Sign Up</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="social-auth-links text-center">
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Microsoft
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a>
                </div>
                <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </div>

        </div>
    </div>
@endsection
