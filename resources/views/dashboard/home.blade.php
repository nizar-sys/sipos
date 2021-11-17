@extends('layouts.app')
@section('title', 'SIPOS | Dashboard')

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item active"><a
                href="{{ route('home', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Dashboard</a></li>
    </ol>
@endsection

@section('widgets')
    @include('_partials.widgets')
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Page visits</h3>
                        </div>
                        <div class="col text-right">
                            <a href="#!" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Page name</th>
                                <th scope="col">Visitors</th>
                                <th scope="col">Unique users</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <a href="{{ route('home', ['role'=>Auth::user()->role == '1' ? 'admin' : 'user']) }}">Dashboard</a>
                                </th>
                                <td>
                                    4,569
                                </td>
                                <td>
                                    340
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
