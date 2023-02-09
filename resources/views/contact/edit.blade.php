@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6">
                <form action="{{ url('Contactupdate', $contact->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name"
                            value="{{ $contact->contact_name }}" placeholder="Enter Contact  Name">
                        <span class="text-danger">
                            @error('contact_name')
                                {{ 'name is required' }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="phone_no" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="phone_no" name="phone_no"
                            value="{{ $contact->phone_no }}" placeholder="Enter Contact  Number">
                        <span class="text-danger">
                            @error('phone_no')
                                {{ 'Contact No  is required & minimum 10 digit' }}
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
