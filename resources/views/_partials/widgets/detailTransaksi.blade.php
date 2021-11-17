<div class="row">
    <div class="col-4">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">ID Pesanan</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $data['transactions']->detail_transaksi }}</span>
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
    <div class="col-4">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Amount</h5>
                        <span
                            class="h2 font-weight-bold mb-0">Rp.{{ number_format($data['transactions']->total_transaksi, 0, ',', '.') }}</span>
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
    <div class="col-4">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Status Transaksi</h5>
                        @php
                            $status = $data['transactions']->status_transaksi;
                            $bgBanner = '';
                            if ($status == 'menunggu pembayaran') {
                                $bgBanner = 'warning';
                            } elseif ($status == 'dikonfirmasi') {
                                $bgBanner = 'primary';
                            } elseif ($status == 'berhasil') {
                                $bgBanner = 'success';
                            } else {
                                $bgBanner = 'danger';
                            }
                        @endphp
                        <span
                            class="h2 font-weight-bold mb-0 badge badge-pill badge-{{ $bgBanner }}">{{ __(Str::title($data['transactions']->status_transaksi)) }}</span>
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
