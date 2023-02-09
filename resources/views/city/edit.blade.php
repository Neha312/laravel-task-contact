@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6">
                <form action="{{ url('update', $city->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="city_name" class="form-label">CityName</label>
                        <input type="text" class="form-control" id="city_name" name="city_name"
                            value="{{ $city->city_name }}" placeholder="Enter City  Name">
                        <span class="text-danger">
                            @error('name')
                                {{ 'name is required' }}
                            @enderror
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
