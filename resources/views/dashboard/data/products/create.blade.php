@extends('layouts.app')
@section('title', 'SIPOS | Tambah Data Produk')
@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a
                href="{{ route('home', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('product.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Data
                Produk</a></li>
        <li class="breadcrumb-item active"><a
                href="{{ route('product.create', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Tambah Data
                Produk</a></li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-muted">Manual Create</h5>
                    <form action="{{ route('product.store') }}" method="post" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-basket"></i></span>
                                </div>
                                <input class="form-control" name="kode_produk" placeholder="Kode Produk" type="text"
                                    value="{{ old('kode_produk') }}">
                            </div>
                            @error('kode_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-basket"></i></span>
                                </div>
                                <input class="form-control" name="nama_produk" placeholder="Nama Produk" type="text"
                                    value="{{ old('nama_produk') }}">
                            </div>
                            @error('nama_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-basket"></i></span>
                                </div>
                                <input class="form-control" name="kategori_produk" placeholder="Kategori Produk"
                                    type="text" value="{{ old('kategori_produk') }}">
                            </div>
                            @error('kategori_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-basket"></i></span>
                                </div>
                                <input class="form-control" name="harga_produk" placeholder="Harga Produk" type="text"
                                    value="{{ old('harga_produk') }}">
                            </div>
                            @error('harga_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-basket"></i></span>
                                </div>
                                <input class="form-control" name="diskon_produk" placeholder="Diskon Produk" type="text"
                                    value="{{ old('diskon_produk') }}">
                            </div>
                            @error('diskon_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-app"></i></span>
                                </div>
                                <input class="form-control" name="stok_produk" placeholder="Stok Produk" type="text"
                                    value="{{ old('stok_produk') }}">
                            </div>
                            @error('stok_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-camera-compact"></i></span>
                                </div>
                                <input class="form-control" name="gambar_produk" type="file"
                                    value="{{ old('gambar_produk') }}">
                            </div>
                            @error('gambar_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-outline-primary btn-block"><i class="ni ni-send"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <form action="{{ route('produk.import.store') }}" class="d-none form-upload-user"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" id="fileInput" onchange="getFileData(this)">

                                </form>
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">upload
                                        your file excel</h5>
                                    <span class="h2 font-weight-bold mb-0" id="filename-upload"></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i onclick="$('#fileInput').click()" class="fas fa-file-excel"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <p class="description">
                                Tatacara upload data
                            <ul>
                                <li>Klik icon excel</li>
                                <li>Pilih file</li>
                                <li><span>Pastikan sesuai format default</span></li>
                                <li><span>Klik tombol kirim dan data akan ditambahkan secara otomatis</span></li>
                            </ul>
                            <a href="{{ route('download.file', ['filename' => 'Contoh-Data-Produk-SIPOS.xlsx']) }}">Unduh
                                contoh format</a>
                            </p>

                            <button type="button" onclick="$('.form-upload-user').submit()"
                                class="btn btn-outline-primary btn-block mt-2"><i class="ni ni-send"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('c_js')
    @include('_partials.funcJs.filterDatatable')
@endsection