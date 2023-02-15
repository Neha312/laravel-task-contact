@extends('layout.main')
@section('main')
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <div class="container mt-4">
        <ul class="nav nav-pills nav-pills-bg-soft justify-content-sm-end mb-4 ">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewState"> Create New State</a>
        </ul>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
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
                    <form id="stateForm" name="stateForm" class="form-horizontal">
                        <input type="hidden" name="state_id" id="state_id">
                        <div class="form-group">
                            <label for="state_name" class="col-sm-2 control-label">State Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="state_name" name="state_name"
                                    placeholder="Enter State Name" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state_name" class="col-sm-2 control-label">Country Name</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="country_id" id="country_id">
                                    <option hidden>Choose Country Name</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
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
                ajax: "{{ route('state-crud.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'state_name',
                        name: 'state_name'
                    },
                    {
                        data: 'country_id',
                        name: 'country_id'
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
            $('#createNewState').click(function() {
                $('#saveBtn').val("create-state");
                $('#state_id').val('');
                $('#stateForm').trigger("reset");
                $('#modelHeading').html("Create New Country");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $(document).on('click', '.editState', function() {
                var state_id = $(this).data('id');
                $.get("{{ route('state-crud.index') }}" + '/' + state_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit State");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#state_id').val(data.id);
                    $('#state_name').val(data.state_name);
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
                    data: $('#stateForm').serialize(),
                    url: "{{ route('state-crud.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#stateForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        Command: toastr["success"](
                            "Save State Successfully!",
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
            $(document).on('click', '.deleteState', function() {

                var state_id = $(this).data("id");

                if (confirm("Are You sure want to delete !")) {

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('state-crud.store') }}" + '/' + state_id,
                        success: function(data) {
                            table.draw();
                            Command: toastr["success"](
                                "State Deleted Successfully!",
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
