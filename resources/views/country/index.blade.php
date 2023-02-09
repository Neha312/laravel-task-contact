@extends('layout.main')
@section('main')
    <div class="container mt-5">
        <div class="row justify-content-between">
            <div class="col-sm-5  align-item-center pt-5">
                <form method="POST" action="{{ url('countryCreate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="country_name" class="form-label">Country Name</label>
                        <input type="text" class="form-control" id="country_name" name="country_name"
                            placeholder="Enter Country Name">
                        <span class="text-danger">
                            @error('country_name')
                                {{ 'Country Name is required & must only contains letters' }}
                            @enderror
                        </span>
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
            <div class="col-sm-5 align-item pt-3">
                <br><br>
                <table class="table  table-hover pt-5">
                    <thead class="table-active">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Country Name</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <th>{{ $country->id }}</th>
                                <td>{{ $country->country_name }}</td>
                                <td>
                                    <a href="{{ url('countryEdit', $country->id) }}" class="btn btn-info btn-sm"><i
                                            class="bi bi-pencil-square"></i>Edit</a>

                                </td>
                                <td>
                                    <form method="POST" action="{{ url('countryDelete', $country->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm"
                                            data-toggle="tooltip" title='Delete'><i
                                                class="bi bi-trash-fill"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {{ $countries->links() }}
                </nav>
                <style>
                    .w-5 {
                        display: none;
                    }
                </style>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
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
