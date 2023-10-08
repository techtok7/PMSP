@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('profile.update') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header text-center">
                                <h3 class="card-title">User Profile Update</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="{{ $user->name }}" placeholder="Full name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-envelope"></span>
                                                    </div>
                                                </div>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    value="{{ $user->email }}" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Minimum Minutes:</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-clock"></span>
                                                    </div>
                                                </div>
                                                <input type="number" name="minimum_minutes" id="minimum_minutes"
                                                    class="form-control" value="{{ $user->minimum_minutes }}"
                                                    placeholder="Minimum minutes">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Maximum Minutes:</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-clock"></span>
                                                    </div>
                                                </div>
                                                <input type="number" name="maximum_minutes" id="maximum_minutes"
                                                    class="form-control" value="{{ $user->maximum_minutes }}"
                                                    placeholder="Maximum minutes">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 offset-4">
                                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
