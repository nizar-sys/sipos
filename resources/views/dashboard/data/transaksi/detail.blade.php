@extends('layouts.app')
@section('title', 'SIPOS | Detail Transaksi')
@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a
                href="{{ route('home', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('transaction.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'users']) }}">Data
                Transaksi</a></li>
        <li class="breadcrumb-item active"><a
                href="{{ route('transaction.detail', ['role' => Auth::user()->role == '1' ? 'admin' : 'users', 'id' => base64_encode($data['transactions']->detail_transaksi)]) }}">Detil
                Transaksi
            </a></li>
    </ol>
@endsection

@section('content')
    @include('_partials.modals.detailImage')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="alert alert-default" role="alert">
                    <strong>Transaksi!</strong> {{ __(Str::title($data['transactions']->status_transaksi)) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        @include('_partials.widgets.detailTransaksi')
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detil Pesanan</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class='row'>
                                <div class="col-md-6">
                                    <tr>
                                        <strong>ID Pesanan</strong>
                                    </tr>
                                </div>
                                <div class="col-md-6">
                                    <tr>
                                        <td>{{ $data['transactions']->detail_transaksi }}</td>
                                    </tr>
                                </div>
                            </div>
                            <div class="mb-3"></div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <tr>
                                        <strong>{{ __('Amount') }}</strong>
                                    </tr>
                                </div>
                                <div class="col-md-6">
                                    <tr>
                                        <td>Rp.{{ number_format($data['transactions']->total_transaksi, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </div>
                            </div>
                            <div class="mb-3"></div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <tr>
                                        <strong>{{ __('Waktu & Tanggal') }}</strong>
                                    </tr>
                                </div>
                                <div class="col-md-6">
                                    <tr>
                                        <td>{{ $data['transactions']->tanggal_transaksi }}
                                        </td>
                                    </tr>
                                </div>
                            </div>
                            <div class="mb-3"></div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <tr>
                                        <strong>{{ __('Status') }}</strong>
                                    </tr>
                                </div>
                                <div class="col-md-6">
                                    <tr>
                                        <td>{{ Str::title($data['transactions']->status_transaksi) }}
                                        </td>
                                    </tr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detil Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $pelanggan = $data['transactions']->carts()->first()->user;
                        @endphp
                        <div class="container-fluid">
                            <div class='row'>
                                <div class="col-md-6">
                                    <tr>
                                        <strong>Nama</strong>
                                    </tr>
                                </div>
                                <div class="col-md-6">
                                    <tr>
                                        <td>{{ Str::title($pelanggan->username) }}</td>
                                    </tr>
                                </div>
                            </div>
                            <div class="mb-3"></div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <tr>
                                        <strong>{{ __('Email') }}</strong>
                                    </tr>
                                </div>
                                <div class="col-md-6">
                                    <tr>
                                        <td>{{ $pelanggan->email }}</td>
                                    </tr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detil Item(s)</h3>
                    </div>
                    <div class="card-body">
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="budget">Nama produk</th>
                                        <th scope="col" class="sort" data-sort="kategori">Kuantitas</th>
                                        <th scope="col" class="sort" data-sort="create at">Harga Produk</th>
                                        <th scope="col" class="sort" data-sort="create at">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($data['transactions']->carts as $cart)
                                        <tr>
                                            @foreach ($cart->product->get() as $product)
                                                <td>{{ $product->nama_produk }}</td>
                                            @endforeach
                                            <td>{{ $cart->qty }}</td>
                                            @foreach ($cart->product->get() as $product)
                                                <td> Rp.{{ number_format($product->harga_produk - ($product->harga_produk * $product->diskon_produk) / 100, 0, ',', '.') }}
                                                </td>
                                            @endforeach
                                            <td>Rp.{{ number_format($cart->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Rp.{{ number_format($data['transactions']->total_transaksi) }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($data['transactions']->payment)
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Sejarah Pembayaran') }}</h3>
                        </div>
                        <div class="card-body">
                            <!-- Light table -->
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="budget">Waktu Pembayaran</th>
                                            <th scope="col" class="sort" data-sort="kategori">Bukti Pembayaran</th>
                                            <th scope="col" class="sort" data-sort="create at">Jumlah Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $payment = $data['transactions']->payment;
                                        @endphp
                                        <tr>
                                            <td>{{ $payment->created_at }}</td>
                                            <td>
                                                <div class="avatar-group">
                                                    <span style="cursor: pointer" class="avatar rounded-circle"
                                                        data-toggle="tooltip"
                                                        data-original-title="{{ Str::title('Bukti Pembayaran ' . $payment->trx_code) }}">
                                                        <img onclick="detailImage(this)"
                                                            alt="{{ 'Bukti Pembayaran ' . $payment->trx_code }}"
                                                            src="{{ asset('/storage/fileUploads/' . $payment->proof_payment) }}"
                                                            id="{{ $payment->trx_code }}">
                                                    </span>
                                                </div>
                                            </td>
                                            <td>Rp.{{ number_format($payment->total_payment, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection


@section('c_js')
    @include('_partials.funcJs.filterDatatable')
@endsection
