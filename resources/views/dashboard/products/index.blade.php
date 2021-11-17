@extends('layouts.app')
@section('title', 'SIPOS | Data Produk')
@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a
                href="{{ route('home', ['role' => Auth::user()->role == '1' ? 'admin' : 'users']) }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a
                href="{{ route('product.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'users']) }}">
                Produk</a></li>
    </ol>
@endsection

@section('c_css')
    @include('_partials.c_css.styleProductCard')
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-wWtaH_iM-JTP4BNI"></script>
@endsection

@section('content')
    @include('_partials.modals.paymentModal')
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card">
                <!-- Light table -->
                <div class="container-fluid mt-4">
                    <div class="row">
                        @foreach ($data['products'] as $produk)
                            <div class="col-md-3 col-sm-6 mr-2">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a href="#" class="image">
                                            <img class="img-1" alt="{{ $produk->nama_produk }}"
                                                src="{{ asset('/storage/productImgs/' . $produk->gambar_produk) }}">
                                        </a>
                                        <ul class="product-links">
                                            <li><a href="#"
                                                    onclick="event.preventDefault(); addToCart({{ $produk->id }}, {{ $produk->harga_produk - ($produk->harga_produk * $produk->diskon_produk) / 100 }})"><i
                                                        class="fas fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-content">
                                        <div class="price">
                                            Rp.{{ number_format($produk->harga_produk - ($produk->harga_produk * $produk->diskon_produk) / 100, 0, ',', '.') }}
                                            <span>Rp.{{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                                        </div>
                                        <h3 class="title"><a href="#">{{ $produk->nama_produk }}</a></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            {{ $data['products']->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card wish-list mb-3">
                            <div class="card-body">

                                <h5 class="mb-4">Cart (<span id="count-cart">0</span> items)</h5>

                                <div id="load-cart">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card mb-3">
                    <div class="card-body" id="load-total-cart">
                    

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('c_js')
    @include('_partials.funcJs.ajaxPromise')
    @include('_partials.funcJs.convertRp')
    @include('_partials.funcJs.cartFuncs')
@endsection
