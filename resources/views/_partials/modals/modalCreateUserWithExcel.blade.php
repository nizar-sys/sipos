<!-- Modal -->
<div class="modal fade" id="modalCreateUserWithExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna <br> <span
                        class="text-danger text-sm ">Password diisi otomatis (<i>SIPOS-1922</i>)</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-2-tab" data-toggle="tab"
                                href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                aria-selected="false"><i class="ni ni-send mr-2"></i>Manual</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-1-tab" data-toggle="tab"
                                href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>Export Excel</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-2" role="tabpanel"
                                aria-labelledby="tabs-icons-text-2-tab">

                                {{-- manual create --}}

                                <form action="{{ route('user.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="password" value="SIPOS-1922">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text"
                                            class="form-control @error('username')
                                            is-invalid
                                        @enderror"
                                            id="username" placeholder="New Username" name="username"
                                            value="{{ old('username') }}">

                                        @error('username')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text"
                                            class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                            id="email" placeholder="New Email" name="email"
                                            value="{{ old('email') }}">

                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Status</label>
                                        <select
                                            class="form-control @error('role')
                                        is-invalid
                                    @enderror"
                                            id="role" name="role">
                                            <option value="0" selected>User</option>
                                            <option value="1">Admin</option>
                                        </select>

                                        @error('role')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-block btn-outline-primary"><i
                                            class="ni ni-send"></i></button>
                                </form>

                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-1" role="tabpanel"
                                aria-labelledby="tabs-icons-text-1-tab">

                                {{-- excel create --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <form action="{{ route('user.import.store') }}" class="d-none form-upload-user" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" name="file" id="fileInput" onchange="getFileData(this)">
                                                    
                                                </form>
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">upload
                                                        your file excel</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="filename-upload"></span>
                                                </div>
                                                <div class="col-auto">
                                                    <div
                                                        class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
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
                                                <a href="{{ route('download.file', ['filename'=>'Contoh-Data-Pengguna-SIPOS.xlsx']) }}">Unduh contoh format</a>
                                            </p>

                                            <button type="button" onclick="$('.form-upload-user').submit()" class="btn btn-outline-primary btn-block mt-2"><i class="ni ni-send"></i></button>
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
