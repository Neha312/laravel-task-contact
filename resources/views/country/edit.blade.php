@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6">
                <form action="{{ url('countryUpdate', $country->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="country_name" class="form-label">Country Name</label>
                        <input type="text" class="form-control" id="country_name" name="country_name"
                            value="{{ $country->country_name }}" placeholder="Enter Country Name">
                        <span class="text-danger">
                            @error('country_name')
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
