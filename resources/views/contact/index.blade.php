@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row justify-content-between">
            <div class="col-sm-5  align-item-center pt-5">
                <form method="POST" action="{{ url('Contactcreate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name"
                            placeholder="Enter Contact Name">
                        <span class="text-danger">
                            @error('contact_name')
                                {{ 'contact Name is required & must only contains letters' }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="phone_no" class="form-label">Contact Number</label>
                        <input type="number" class="form-control" id="phone_no" name="phone_no"
                            placeholder="Enter Contact Number">
                        <span class="text-danger">
                            @error('phone_no')
                                {{ 'contact Number is required & must only contains Number' }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-control-label" for="country">Country</label>
                        <select id="country-dropdown" class="form-control" name="country_id">
                            <option value="">-- Select Country --</option>
                            @foreach ($countries as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->country_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-control-label" for="state">State</label>
                        <select id="state-dropdown" class="form-control" name="state_id">
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="city">City</label>
                        <select id="city-dropdown" class="form-control" name="city_id">
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <br>
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            <div class="col-sm-5">
                <br><br>
                <table class="table table-hover">
                    <thead class="table-active">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Contact Name</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Country Name</th>
                            <th scope="col">State Name</th>
                            <th scope="col">City Name</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <th>{{ $contact->id }}</th>
                                <td>{{ $contact->contact_name }}</td>
                                <td>{{ $contact->phone_no }}</td>
                                <td>{{ $contact->country->country_name }}</td>
                                <td>{{ $contact->state->state_name }}</td>
                                <td>{{ $contact->city->city_name }}</td>
                                <td>
                                    <a href="{{ url('Contactedit', $contact->id) }}" class="btn btn-info btn-sm"><i
                                            class="bi bi-pencil-square"></i>Edit</a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ url('Contactdelete', $contact->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit"
                                            class="btn btn-xs btn-danger btn-flat show_confirm_permission"
                                            data-toggle="tooltip" title='Delete'><i
                                                class="bi bi-trash-fill"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <br>
                <span>
                    {{ $contacts->links() }}
                </span>
                <style>
                    .w-5 {
                        display: none;
                    }
                </style>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.show_confirm_permission').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
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
