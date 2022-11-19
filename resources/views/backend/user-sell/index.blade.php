@extends('backend.layout.app')

@push('custom-css')
@endpush

@section('main_section')
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Sells List</h4>
                        </div>

                    </div>
                    <div class="iq-card-body">
                        <div id="table" class="table-editable">
                            {{-- <form action="" method="GET" class="form-inline">
                                <div class="form-group mb-2">

                                </div>
                                <button type="submit" class="btn btn-primary ml-2">Filter</button>
                            </form> --}}
                            <table class="table table-bordered table-responsive-md table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Title</th>
                                        <th>price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                @foreach ($sells as $sell)
                                <tr>
                                    <td>{{$sells->firstItem() + $loop->index}}</td>
                                    <td style="text-align: left">{{$sell->name}}</td>
                                    <td>${{$sell->price}}</td>
                                    <td>{{$sell->sells_count}}</td>
                                    <td>${{$sell->price *$sell->sells_count}}</td>
                                </tr>
                                @endforeach
                                <tbody>
                                </tbody>

                            </table>
                            {{$sells->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
