@extends('layout.app')
@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <main class="login-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h1> Forget Password </h1>
                            You Can get your password here.
                        </div>
                        <div class="card-body">
                            <form action="{{ route('forgetPassword') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" name="email" class="form-control" placeholder="Enter Email" />
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block"> Forget Password </button>
                                </div>
                            </form>
                            <a href="login">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
