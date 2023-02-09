<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Dynamic Dependent Dropdown using Ajax Example - NiceSnippets.com</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style type="text/css">
        body {
            background-color: #d2d2d2 !important;
        }

        .dropdown {
            background-color: #fff;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 justify-content-center">
        <div class="row">
            <div class="col-md-12 dropdown rounded p-5 mt-5">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <h4>Laravel Dynamic Dependent Dropdown using Ajax Example</h4>
                    </div>
                    <div class="col-md-3 mb-3 text-end">
                        <strong class="col-md-5 p-0 m-0 text-end" style="color: #008B8B">NiceSnippets.com</strong>
                    </div>
                </div>
                <form>
                    <div class="form-group mb-3">
                        <label class="form-control-label" for="country">Country</label>
                        <select id="country-dropdown" class="form-control" name="id">
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
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

</html>
