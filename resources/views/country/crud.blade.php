@extends('layout.main')
@section('main')
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <div class="container mt-4">
        <ul class="nav nav-pills nav-pills-bg-soft justify-content-sm-end mb-4 ">
            <a class="btn btn-success" href="javascript:void(0)" id="createNewCountry"> Create New Country</a>
        </ul>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
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
                    <form id="countryForm" name="countryForm" class="form-horizontal">
                        <input type="hidden" name="country_id" id="country_id">
                        <div class="form-group">
                            <label for="country_name" class="col-sm-2 control-label">Country Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="country_name" name="country_name"
                                    placeholder="Enter Country Name" value="" maxlength="50" required="">
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
                ajax: "{{ route('country-crud.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'country_name',
                        name: 'country_name'
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
            $('#createNewCountry').click(function() {
                $('#saveBtn').val("create-country");
                $('#country_id').val('');
                $('#countryForm').trigger("reset");
                $('#modelHeading').html("Create New Country");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $(document).on('click', '.editCountry', function() {
                var country_id = $(this).data('id');
                $.get("{{ route('country-crud.index') }}" + '/' + country_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit Country");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#country_id').val(data.id);
                    $('#country_name').val(data.country_name);

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
                    data: $('#countryForm').serialize(),
                    url: "{{ route('country-crud.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#countryForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        Command: toastr["success"](
                            "Save Country Successfully!",
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
            $(document).on('click', '.deleteCountry', function() {

                var country_id = $(this).data("id");

                if (confirm("Are You sure want to delete !")) {

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('country-crud.store') }}" + '/' + country_id,
                        success: function(data) {
                            table.draw();
                            Command: toastr["success"](
                                "Country Deleted Successfully!",
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
