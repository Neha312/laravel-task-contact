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
                    <div class="form-group mb-3">
                        <label class="form-control-label" for="country">Country</label>
                        <select id="country-dropdown" class="form-control" name="country_id">
                            <option value="">-- Select Country --</option>
                            @if (!empty($countries))
                                @foreach ($countries as $country)
                                    <option {{ $contact->country_id == $country->id ? 'selected' : '' }}
                                        value="{{ $country->id }}">
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-control-label" for="state">State</label>
                        <select id="state-dropdown" class="form-control" name="state_id">
                            @if (!empty($states))
                                @foreach ($states as $state)
                                    <option {{ $contact->state_id == $state->id ? 'selected' : '' }}
                                        value="{{ $state->id }}">
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="city">City</label>
                        <select id="city-dropdown" class="form-control" name="city_id">
                            @if (!empty($cities))
                                @foreach ($cities as $city)
                                    <option {{ $contact->city_id == $city->id ? 'selected' : '' }}
                                        value="{{ $city->id }}">
                                        {{ $city->city_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {

            /*------------------------------------------
            --------------------------------------------
            Country Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#country-dropdown').on('change', function() {
                var idCountry = this.value;
                // alert(idCountry)
                $("#state-dropdown").html('');
                $.ajax({
                    url: "{{ url('fetch-states') }}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state-dropdown').html(
                            '<option value="">-- Select State --</option>');
                        $.each(result.states, function(key, value) {
                            $("#state-dropdown").append('<option value="' + value
                                .id + '">' + value.state_name + '</option>');
                        });
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            State Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#state-dropdown').on('change', function() {
                var idState = this.value;
                // alert(idState)
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ url('fetch-cities') }}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value
                                .id + '">' + value.city_name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
