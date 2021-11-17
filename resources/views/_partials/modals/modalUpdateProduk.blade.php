<!-- Modal -->
<div class="modal fade" id="modalUpdateProduk" tabindex="-1" role="dialog" aria-labelledby="label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelModalUpdateProduk">Ubah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.update') }}" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_produk" id="id_produk">
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

                    <button class="btn btn-outline-primary btn-block"><i class="ni ni-send"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
