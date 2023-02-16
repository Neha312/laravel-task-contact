@extends('layout.main')
@section('main')
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <div class="container mt-4">
        <ul class="nav nav-pills nav-pills-bg-soft justify-content-sm-end mb-4 ">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewCity"> Create New City</a>
        </ul>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
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
                    <form id="cityForm" name="cityForm" class="form-horizontal">
                        <input type="hidden" name="city_id" id="city_id">
                        <div class="form-group">
                            <label for="state_name" class="col-sm-2 control-label">City Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="city_name" name="city_name"
                                    placeholder="Enter City  Name" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state_name" class="col-sm-2 control-label">State Name</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="state_id" id="state_id">
                                    <option hidden>Choose State Name</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                ajax: "{{ route('city-crud.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'city_name',
                        name: 'city_name'
                    },
                    {
                        data: 'state',
                        name: 'state.state_name'
                    },
                    {
                        data: 'country',
                        name: 'country.country_name'
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
            $('#createNewCity').click(function() {
                $('#saveBtn').val("create-city");
                $('#city_id').val('');
                $('#cityForm').trigger("reset");
                $('#modelHeading').html("Create New City");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $(document).on('click', '.editCity', function() {
                var city_id = $(this).data('id');
                $.get("{{ route('city-crud.index') }}" + '/' + city_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit City");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#city_id').val(data.id);
                    $('#city_name').val(data.city_name);
                    $('#state_id').val(data.state_id);

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
                    data: $('#cityForm').serialize(),
                    url: "{{ route('city-crud.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#cityForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        Command: toastr["success"](
                            "Save City Successfully!",
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
            $(document).on('click', '.deleteCity', function() {

                var city_id = $(this).data("id");

                if (confirm("Are You sure want to delete !")) {

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('city-crud.store') }}" + '/' + city_id,
                        success: function(data) {
                            table.draw();
                            Command: toastr["success"](
                                "City Deleted Successfully!",
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
