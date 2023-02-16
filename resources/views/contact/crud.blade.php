@extends('layout.main')
@section('main')
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <div class="container mt-4">
        <ul class="nav nav-pills nav-pills-bg-soft justify-content-sm-end mb-4 ">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewContact"> Create New Contact</a>
        </ul>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Contact Name</th>
                    <th>City Name</th>
                    <th>State Name</th>
                    <th>Country Name</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                @if (Session::has('error'))
                    <p class="text-danger">{{ Session::get('error') }}</p>
                @endif
                @if (Session::has('success'))
                    <p class="text-danger">{{ Session::get('success') }}</p>
                @endif
                <div class="modal-body">
                    <form id="contactForm" name="contactForm" class="form-horizontal">
                        <input type="hidden" name="contact_id" id="contact_id">
                        <div class="form-group">
                            <label for="state_name" class="col-sm-2 control-label">Contact Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="contact_name" name="contact_name"
                                    placeholder="Enter Contact Name" value="" maxlength="50" required="">
                                <span class="text-danger">
                                    @error('contact_name')
                                        {{ 'contact Number is required & must only contains Number' }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone_no" class="col-sm-2 control-label">Contact Number</label>
                            <input type="number" class="form-control" id="phone_no" name="phone_no"
                                placeholder="Enter Contact Number">
                            <span class="text-danger">
                                @error('phone_no')
                                    {{ 'contact Number is required & must only contains Number' }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="country">Country</label>
                            <select id="country-dropdown" class="form-control" name="country_id">
                                <option value="">-- Select Country --</option>
                                @foreach ($countries as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"for="state">State</label>
                            <select id="state-dropdown" class="form-control" name="state_id">
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="city">City</label>
                            <select id="city-dropdown" class="form-control" name="city_id">
                            </select>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10 mt-3">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                                changes
                            </button>
                        </div>
                    </form>
                    {!! Toastr::message() !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
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
        $(function() {

            /*------------------------------------------
             --------------------------------------------
             Pass Header Token
             --------------------------------------------
             --------------------------------------------*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /*------------------------------------------
            --------------------------------------------
            Render DataTable
            --------------------------------------------
            --------------------------------------------*/
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('contact-crud.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'contact_name',
                        name: 'contact_name'
                    },
                    // {
                    //     data: 'phone_no',
                    //     name: 'phone_no'
                    // },
                    {
                        data: 'city_id',
                        name: 'city_id'
                    },
                    {
                        data: 'state_id',
                        name: 'state_id'
                    },
                    {
                        data: 'state_id',
                        name: 'state_id'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    },
                ]
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Add Button
            --------------------------------------------
            --------------------------------------------*/
            $('#createNewContact').click(function() {
                $('#saveBtn').val("create-contact");
                $('#contact_id').val('');
                $('#contactForm').trigger("reset");
                $('#modelHeading').html("Create New Contact");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $(document).on('click', '.editContact', function() {
                var contact_id = $(this).data('id');
                $.get("{{ route('contact-crud.index') }}" + '/' + contact_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit Contact");
                    $('#saveBtn').val("edit-contact");
                    $('#ajaxModel').modal('show');
                    $('#contact_id').val(data.id);
                    $('#contact_name').val(data.contact_name);
                    $('#phone_no').val(data.phone_no);
                    $('#city_id').val(data.city_id);
                    $('#state_id').val(data.state_id);
                    $('#country_id').val(data.country_id);

                })
            });

            /*------------------------------------------
            --------------------------------------------
            Create Member  Code
            --------------------------------------------
            --------------------------------------------*/
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Save');

                $.ajax({
                    data: $('#contactForm').serialize(),
                    url: "{{ route('contact-crud.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#contactForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        Command: toastr["success"](
                            "Save Member Successfully!",
                            "success")

                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            Delete Member Code
            --------------------------------------------
            --------------------------------------------*/
            $(document).on('click', '.deleteContact', function() {

                var city_id = $(this).data("id");

                if (confirm("Are You sure want to delete !")) {

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('contact-crud.store') }}" + '/' + contact_id,
                        success: function(data) {
                            table.draw();
                            Command: toastr["success"](
                                "Member Deleted Successfully!",
                                "success")

                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-center",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });

                }


            });

        });
    </script>
@endsection
