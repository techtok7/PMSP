@extends('layouts.authentication')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Verify your email address</p>
                <form action="{{ route('verification.store') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="otp" id="otp" class="form-control" placeholder="OTP"
                            value="{{ old('otp') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Verify</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
