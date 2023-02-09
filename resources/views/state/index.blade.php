@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row justify-content-between">
            <div class="col-sm-5  align-item-center pt-5">
                <form method="POST" action="{{ url('Statecreate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="state_name" class="form-label">State Name</label>
                        <input type="text" class="form-control" id="state_name" name="state_name"
                            placeholder="Enter State Name">
                        <span class="text-danger">
                            @error('state_name')
                                {{ 'State Name is required & must only contains letters' }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="country_id" id="country_name">
                            <option hidden>Choose Country Name</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
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
                            <th scope="col">State Name</th>
                            <th scope="col">Country Name</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $state)
                            <tr>
                                <th>{{ $state->id }}</th>
                                <td>{{ $state->state_name }}</td>
                                <td>{{ $state->country->country_name }}</td>

                                <td>
                                    <a href="{{ url('Stateedit', $state->id) }}" class="btn btn-info btn-sm"><i
                                            class="bi bi-pencil-square"></i>Edit</a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ url('Statedelete', $state->id) }}">
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
                    {{ $states->links() }}
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
