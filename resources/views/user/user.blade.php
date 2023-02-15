@extends('layout.main')
@section('main')
    <a href="{{ url('createUser') }}" class="btn btn-success btn-sm mt-3">Add</a>
    <div class="container mt-4">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                if (confirm("Are you sure you want to edit this record")) {
                    window.location.href = "editUser/" + id;

                }

            });
            $(document).on('click', '.delete', function() {
                var id = $(this).attr('id');
                if (confirm("Are you sure you want to delete this record?")) {
                    window.location.href = "deleteUser/" + id;

                }

            });
        });
    </script>
@endsection
