@extends('layouts.blankBootstrap')
@section('title', 'SIPOS | Receipt Transaction')


@section('c_css')
    <style>
        body {
            margin-top: 20px;
            background: #eee;
        }

        /*Invoice*/
        .invoice .top-left {
            font-size: 65px;
            color: #3ba0ff;
        }

        .invoice .top-right {
            text-align: right;
            padding-right: 20px;
        }

        .invoice .table-row {
            margin-left: -15px;
            margin-right: -15px;
            margin-top: 25px;
        }

        .invoice .payment-info {
            font-weight: 500;
        }

        .invoice .table-row .table>thead {
            border-top: 1px solid #ddd;
        }

        .invoice .table-row .table>thead>tr>th {
            border-bottom: none;
        }

        .invoice .table>tbody>tr>td {
            padding: 8px 20px;
        }

        .invoice .invoice-total {
            margin-right: -10px;
            font-size: 16px;
        }

        .invoice .last-row {
            border-bottom: 1px solid #ddd;
        }

        .invoice-ribbon {
            width: 85px;
            height: 88px;
            overflow: hidden;
            position: absolute;
            top: -1px;
            right: 14px;
        }

        .ribbon-inner {
            text-align: center;
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            position: relative;
            padding: 7px 0;
            left: -5px;
            top: 11px;
            width: 120px;
            background-color: #66c591;
            font-size: 15px;
            color: #fff;
        }

        .ribbon-inner:before,
        .ribbon-inner:after {
            content: "";
            position: absolute;
        }

        .ribbon-inner:before {
            left: 0;
        }

        .ribbon-inner:after {
            right: 0;
        }

        @media(max-width:575px) {

            .invoice .top-left,
            .invoice .top-right,
            .invoice .payment-details {
                text-align: center;
            }

            .invoice .from,
            .invoice .to,
            .invoice .payment-details {
                float: none;
                width: 100%;
                text-align: center;
                margin-bottom: 25px;
            }

            .invoice p.lead,
            .invoice .from p.lead,
            .invoice .to p.lead,
            .invoice .payment-details p.lead {
                font-size: 22px;
            }

            .invoice .btn {
                margin-top: 10px;
            }
        }

        @media print {
            .invoice {
                width: 900px;
                height: 800px;
            }
        }

    </style>
@endsection

@section('content')
    <div class="container bootstrap snippets bootdeys">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default invoice" id="invoice">
                    <div class="panel-body">
                        <div class="invoice-ribbon">
                            <div class="ribbon-inner">{{ __($data['transactions']->status_transaksi) }}</div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 top-left">
                                <i class="fa fa-rocket"></i>
                            </div>

                            <div class="col-sm-6 top-right">
                                <h3 class="marginright">INVOICE-{{ $data['transactions']->detail_transaksi }}</h3>
                                <span
                                    class="marginright">{{ date('d M Y', strtotime($data['transactions']->tanggal_transaksi)) }}</span>
                            </div>

                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-xs-4 text-right payment-details">
                                <p class="lead marginbottom payment-info">Payment details</p>
                                <p>Date: {{ date('d M Y', strtotime($data['transactions']->tanggal_transaksi)) }}</p>
                                <p>Total Amount:
                                    <strong>Rp.{{ number_format($data['transactions']->total_transaksi, 0, ',', '.') }}</strong>
                                </p>
                            </div>

                        </div>

                        <div class="row table-row">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:50%">Item</th>
                                        <th class="text-right" style="width:15%">Unit Price</th>
                                        <th class="text-right" style="width:15%">Quantity</th>
                                        <th class="text-right" style="width:15%">Subtotal Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['transactions']->carts as $cart)
                                        <tr>
                                            @foreach ($cart->product->get() as $produk)
                                                <td>{{ $produk->nama_produk }}</td>
                                                <td class="text-right">
                                                    Rp.{{ number_format($produk->harga_produk - ($produk->harga_produk * $produk->diskon_produk) / 100, 0, ',', '.') }}
                                                </td>
                                            @endforeach
                                            <td class="text-right">{{ $cart->qty }}</td>
                                            <td class="text-right">
                                                Rp.{{ number_format($cart->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="row">
                            <div class="col-xs-6 margintop">
                                <p class="lead marginbottom">THANK YOU!</p>

                                <button onclick="window.print()" class="btn btn-success" id="invoice-print"><i
                                        class="fa fa-print"></i> Print
                                    Invoice</button>
                                @if (Auth::user()->role == '1')
                                    @php
                                        $transaksi = $data['transactions'];
                                        $user = $transaksi->carts()->first()->user;
                                    @endphp
                                    <a href="{{ route('mail.receipt', ['trxID' => base64_encode($transaksi->detail_transaksi), 'email' => $user->email]) }}"
                                        class="btn btn-danger"><i class="fas fa-envelope"></i> Mail Invoice</a>
                                @endif
                            </div>
                            <div class="col-xs-6 text-right pull-right invoice-total">
                                <div class="row">
                                    <div class="col-3">
                                        <p>Total Due:
                                            <strong>Rp.{{ number_format($data['transactions']->total_transaksi, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="col-3">
                                        <p>Your Payment:
                                            <strong>Rp.{{ number_format($data['transactions']->payment->total_payment, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="col-3">
                                        <p>Your Change Payment:
                                            <strong>Rp.{{ number_format($data['transactions']->payment->change_payment, 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
