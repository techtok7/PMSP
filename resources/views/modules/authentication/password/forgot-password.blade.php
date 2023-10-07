@extends('layouts.authentication')
@section('content')
    <div class="login-box">

        <div class="card card-primary card-outline">
            <div class="card-header  text-center">
                <div class="h1"><b>Forgot Password</b></div>
            </div>
            <div class="card-body">
                <form action="{{ route('forgot-password.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
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
