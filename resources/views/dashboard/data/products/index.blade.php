@extends('layouts.app')
@section('title', 'SIPOS | Data Produk')
@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mt-4">
        <li class="breadcrumb-item"><a
                href="{{ route('home', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a
                href="{{ route('product.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'user']) }}">Data
                Produk</a></li>
    </ol>
@endsection
@section('action_btn')
    <a href="{{ route('product.create') }}" class="btn btn-sm btn-neutral">New product</a>

    <button type="button" disabled id="delete-data-selected" class="btn btn-neutral btn-sm">Delete</button>

        <form id="formdelete-select-data" action="{{ route('product.select.destroy') }}" method="post" class="d-none">
            @csrf
            <input type="hidden" name="selectedData" id="selectedData" multiple>
        </form>
@endsection


@section('content')
    @include('_partials.modals.detailImage')
    @include('_partials.modals.modalUpdateProduk')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Kode Produk</th>
                                <th scope="col" class="sort" data-sort="budget">Nama produk</th>
                                <th scope="col" class="sort" data-sort="kategori">Kategori</th>
                                <th scope="col" class="sort" data-sort="create at">Harga Produk</th>
                                <th scope="col" class="sort" data-sort="create at">Harga Diskon Produk</th>
                                <th scope="col" class="sort" data-sort="create at">Harga Jual Produk</th>
                                <th scope="col">Foto Produk</th>
                                <th scope="col" class="sort" data-sort="stok">Stok Produk</th>
                                <th scope="col" id="select-all-data" ondblclick="selectAllData('selectData')">Filter All
                                </th>
                                <th scope="col" class="sort" data-sort="action"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="user-list">
                            @foreach ($data['products'] as $produk)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $produk->kode_produk }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ Str::title($produk->nama_produk) }}
                                    </td>
                                    <td>
                                        <span class="badge badge-dot mr-4">
                                            <span class="kategori">{{ Str::title($produk->kategori_produk) }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        Rp.{{ number_format($produk->harga_produk, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        Rp.{{ number_format($produk->harga_produk*$produk->diskon_produk/100, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        Rp.{{ number_format($produk->harga_produk-$produk->harga_produk*$produk->diskon_produk/100, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="avatar-group">
                                            <span style="cursor: pointer" class="avatar rounded-circle" data-toggle="tooltip"
                                                data-original-title="{{ Str::title($produk->nama_produk) }}">
                                                <img onclick="detailImage(this)" alt="{{$produk->nama_produk}}"
                                                    src="{{ asset('/storage/productImgs/' . $produk->gambar_produk) }}" id="{{$produk->kode_produk}}">
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="ni ni-app"></i>
                                        {{ $produk->stok_produk }}
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="selectData" id="selectData"
                                            onclick="getCheckedCheckboxesFor('selectData')" value="{{ $produk->id }}">
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <span class="dropdown-item" onclick="showDataProd({{$produk->kode_produk}})"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    </div>
@endsection


@section('c_js')
    @include('_partials.funcJs.filterDatatable')
    @include('_partials.funcJs.ajaxPromise')
    <script>
        function bacaGambar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.updateImgProduct').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);

                Swal.fire({
                    title: 'Lanjutkan ubah foto produk?',
                    text: "Jadikan gambar sebagai foto produk",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-update-imgProd').submit()
                    } else {
                        $('.updateImgProduct').attr('src', $('input[name="oldImgProd"]').val());
                    }
                })
            }
        }

        $('input[name="newImgProd"]').change(function() {
            bacaGambar(this);
        });

        async function showDataProd(productCode){
            try {
                var url = '/:role/product/:kodeProd';
                    url = url.replace(':role', "{{Auth::user()->role == '1' ? 'admin' : 'user'}}")
                    url = url.replace(':kodeProd', productCode)

                const response = await HitData(url, null, 'GET');
                var data = response.data
                $('#modalUpdateProduk').modal('show')

                $('#modalUpdateProduk input[name="id_produk"]').val(data.id)
                $('#modalUpdateProduk input[name="kode_produk"]').val(data.kode_produk)
                $('#modalUpdateProduk input[name="nama_produk"]').val(data.nama_produk)
                $('#modalUpdateProduk input[name="kategori_produk"]').val(data.kategori_produk)
                $('#modalUpdateProduk input[name="harga_produk"]').val(data.harga_produk)
                $('#modalUpdateProduk input[name="diskon_produk"]').val(data.diskon_produk)
                $('#modalUpdateProduk input[name="stok_produk"]').val(data.stok_produk)
            } catch (error) {
                Snackbar.show({
                    text: 'Error '.error
                })
            }
        }

        @if($errors->any())
            $('#modalUpdateProduk').modal('show')
        @endif
    </script>
@endsection