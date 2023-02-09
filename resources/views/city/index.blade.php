@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row justify-content-between">
            <div class="col-sm-5  align-item-center pt-5">
                <form method="POST" action="{{ url('create') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="city_name" class="form-label">City Name</label>
                        <input type="text" class="form-control" id="city_name" name="city_name"
                            placeholder="Enter City Name">
                        <span class="text-danger">
                            @error('city_name')
                                {{ 'city Name is required & must only contains letters' }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="state_id" id="state_name">
                            <option hidden>Choose State Name</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                            @endforeach
                        </select>
                    </div>
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
                            <th scope="col">City Name</th>
                            <th scope="col">State Name</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cities as $city)
                            <tr>
                                <th>{{ $city->id }}</th>
                                <td>{{ $city->city_name }}</td>
                                <td>{{ $city->state->state_name }}</td>

                                <td>
                                    <a href="{{ url('edit', $city->id) }}" class="btn btn-info btn-sm"><i
                                            class="bi bi-pencil-square"></i>Edit</a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ url('delete', $city->id) }}">
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
                    {{ $cities->links() }}
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
@endsection
