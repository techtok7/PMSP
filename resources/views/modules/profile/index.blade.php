@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="mt-5 mx-2">
                <div class="card card-primary card-outline">
                    <div class="card-header text-center">
                        <h3 class="card-title">User Profile Update</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $user->name }}" placeholder="Full name">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 offset-4">
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
