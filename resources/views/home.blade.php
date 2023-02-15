<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
</head>

<body>
    @extends('layout.app')
    @section('content')
        <div class="container mt-5">
            <div class="row row-cols-2">
                <div class="col bg-light">
                    <div class="card border-secondary m-auto" style="max-width: 18rem;">
                        <div class="card-header">Contact Module</div>
                        <div class="card-body text-info">
                            <h5 class="card-title">Manage Contact Module</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                        </div>
                    </div>
                </div>
                <div class="col bg-light ">
                    <div class="card border-secondary m-auto" style="max-width: 18rem;">
                        <div class="card-header">City Module</div>
                        <div class="card-body text-info">
                            <h5 class="card-title">Manage City Module</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                        </div>
                    </div>
                </div>
                <div class="col bg-light mt-4">
                    @include('product.echart', ['graphData' => $grp['graphData']])
                </div>
                <div class="col bg-light mt-4">
                    @include('product.barchart', ['chartData' => $grp['chartData']])
                </div>

            </div>
        </div>
    @endsection
</body>

</html>
