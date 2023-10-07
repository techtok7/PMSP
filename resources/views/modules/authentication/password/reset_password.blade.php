@extends('layouts.authentication')
@section('content')
    <div class="login-box">

        <div class="card card-primary card-outline">
            <div class="card-header  text-center">
                <div class="h1"><b>Reset Password</b></div>
            </div>
            <div class="card-body">
                <form action="{{ route('password.process') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                            placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 offset-4">
                            <button type="submit" class="btn btn-primary btn-block">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
