@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6">
                <form action="{{ url('Stateupdate', $state->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="state_name" class="form-label">State Name</label>
                        <input type="text" class="form-control" id="state_name" name="state_name"
                            value="{{ $state->state_name }}" placeholder="Enter Permission Name">
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
