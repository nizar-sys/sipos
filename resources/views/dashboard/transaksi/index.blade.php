@extends('layouts.app')
@section('title', 'SIPOS | Data Transaksi')
@php
    $role = Auth::user()->role == '1' ? 'admin' : 'users';
@endphp
@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a href="{{ route('home', ['role' => $role]) }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('transaction.index', ['role' => $role]) }}">Data
                Transaksi</a></li>
    </ol>
@endsection
@section('content')
    @include('_partials.modals.paymentModal')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Summary') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">Total Pesanan</h5>
                                                <span
                                                    class="h2 font-weight-bold mb-0">{{ $data['transactions']->count() }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                                    <i class="ni ni-chart-pie-35"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">
                                                    {{ __('Jumlah Transaksi Yang Harus Dibayar') }}</h5>
                                                @php
                                                    $total = 0;
                                                    foreach ($data['transactions']->where('status_transaksi', 'menunggu pembayaran') as $trx) {
                                                        $total += $trx->total_transaksi;
                                                    }
                                                @endphp
                                                <span
                                                    class="h2 font-weight-bold mb-0">Rp.{{ number_format($total, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                                    <i class="ni ni-chart-pie-35"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0">
                                                    {{ __('Jumlah Transaksi Yang Berhasil Dibayar') }}</h5>
                                                @php
                                                    $total = 0;
                                                    foreach ($data['transactions']->whereIn('status_transaksi', ['dibayar', 'berhasil']) as $trx) {
                                                        $total += $trx->total_transaksi;
                                                    }
                                                @endphp
                                                <span
                                                    class="h2 font-weight-bold mb-0">Rp.{{ number_format($total, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                                    <i class="ni ni-chart-pie-35"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Tanggal & Waktu</th>
                                    <th scope="col" class="sort" data-sort="budget">ID Pesanan</th>
                                    <th scope="col" class="sort" data-sort="email">Email Pemesan</th>
                                    <th scope="col" class="sort" data-sort="kategori">Jumlah</th>
                                    <th scope="col" class="sort" data-sort="create at">Status</th>
                                    <th scope="col" class="sort" data-sort="action"></th>
                                </tr>
                            </thead>
                            <tbody id="load-transaksi">
                                @foreach ($data['transactions'] as $trx)
                                    <tr>
                                        <td>{{ __($trx->tanggal_transaksi . ',' . $trx->created_at->diffForHumans()) }}
                                        </td>
                                        @php
                                            $role = Auth::user()->role == '1' ? 'admin' : 'user';
                                        @endphp
                                        <td><a
                                                href="{{ route('transaction.detail', ['role' => $role, 'id' => base64_encode($trx->detail_transaksi)]) }}">{{ $trx->detail_transaksi }}</a>
                                        </td>
                                        <td>{{ $trx->user->email }}</td>
                                        <td>Rp.{{ number_format($trx->total_transaksi, 0, ',', '.') }}</td>
                                        @php
                                            $status = $trx->status_transaksi;
                                            $bgBanner = '';
                                            if ($status == 'menunggu pembayaran') {
                                                $bgBanner = 'warning';
                                            } elseif ($status == 'dibayar') {
                                                $bgBanner = 'primary';
                                            } elseif ($status == 'berhasil') {
                                                $bgBanner = 'success';
                                            } else {
                                                $bgBanner = 'danger';
                                            }
                                        @endphp
                                        <td>
                                            <span
                                                @if ($status == 'menunggu pembayaran') style="cursor: pointer"
                                                onclick="payment({{ $trx->detail_transaksi }},
                                                {{ $trx->total_transaksi }})" @endif
                                                class="badge badge-pill badge-{{ $bgBanner }} badge-lg">{{ __($status) }}</span>
                                        </td>
                                        @if ($status != 'menunggu pembayaran')
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('transaction.receipt', ['role' => $role, 'trxID' => base64_encode($trx->detail_transaksi)]) }}"
                                                    target="_blank" class="btn btn-sm"><i
                                                        class="fas fa-file-invoice"></i></a>

                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-arrow text-center">
                                                        @if ($status == 'dibayar')
                                                            <form id="form-cancel-trx"
                                                                action="/transactions/cancel/{{ base64_encode($trx->detail_transaksi) }}"
                                                                method="post">

                                                                @csrf
                                                            </form>
                                                            <a onclick="event.preventDefault(); $('#form-cancel-trx').submit()"
                                                                class="dropdown-item text-danger" href="#">Batalkan
                                                                Transaksi</a>
                                                            <form id="form-success-trx"
                                                                action="/transactions/success/{{ base64_encode($trx->detail_transaksi) }}"
                                                                method="post">

                                                                @csrf
                                                            </form>
                                                            <a onclick="event.preventDefault(); $('#form-success-trx').submit()"
                                                                class="dropdown-item text-success" href="#">Konfirmasi
                                                                Transaksi</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end mb-0">
                                {{ $data['transactions']->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('c_js')
    @include('_partials.funcJs.ajaxPromise')
    @include('_partials.funcJs.convertRp')
    @include('_partials.funcJs.trxUserFuncs')
@endsection
