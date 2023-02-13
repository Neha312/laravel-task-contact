@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row justify-content-between">
            <div class="col-sm-5  align-item-center pt-5">
                <h1>Add User</h1>


                <form action="{{ route('addUser') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="form-group">
                        <label for="email">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" />
                        @if ($errors->has('email'))
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
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
                    <div class="form-group">
                        <label for="confirm password">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Enter Password" />
                    </div>
                    <div class="row">
                        <div class="col-8 text-left">
                            <a href="#" class="btn btn-link"></a>
                        </div>
                        <div class="col-8 text-right">
                            <input type="submit" class="btn btn-primary" value="ADD" />
                        </div>
                    </div>
                </form>
                @if (Session::has('error'))
                    <p class="text-danger">{{ Session::get('error') }}</p>
                @endif
                @if (Session::has('success'))
                    <p class="text-danger">{{ Session::get('success') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
