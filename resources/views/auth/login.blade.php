@extends('layout.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card form-holder">
                    <div class="card-body">
                        <h1>Login</h1>

                        @if (Session::has('error'))
                            <p class="text-danger">{{ Session::get('error') }}</p>
                        @endif
                        @if (Session::has('success'))
                            <p class="text-danger">{{ Session::get('success') }}</p>
                        @endif

                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter Email" />
                                @if ($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" />
                                @if ($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-4 text-left ml-2">
                                    <input type="submit" class="btn btn-primary" value="Login" />
                                </div>
                                <div class="col-8 text-right ">
                                    <a href="forget-password" class="btn btn-link">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
