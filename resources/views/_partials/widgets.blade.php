@php

use App\Models\User;
use App\Models\Produk;
use App\Models\Transaksi;

$user = Auth::user();
$widgets = [
    [
        'name' => 'Total Transaksi',
        'data' => $user->role == '1' ? Transaksi::all() : Transaksi::all()->where('user_detail', $user->id),
        'icon' => 'fas fa-chart-line',
        'url' => route('transaction.index', ['role' => $user->role == '1' ? 'admin' : 'users']),
    ],
    [
        'name' => 'Total Produk',
        'data' => Produk::all(),
        'icon' => 'fab fa-opencart',
        'url' => route('product.index', ['role' => $user->role == '1' ? 'admin' : 'users']),
    ],
    $user->role == '1'
        ? [
            'name' => 'Total Pengguna',
            'data' => User::all(),
            'icon' => 'fas fa-users',
            'url' => route('user.list', ['role' => $user->role == '1' ? 'admin' : 'users']),
        ]
        : null,
];

@endphp
@foreach ($widgets as $widget)
    @if ($widget != null)
        <div class="col-xl-3 col-md-6 col-sm-12">
            <a class="card card-stats" href="{{ $widget['url'] }}">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">{{ $widget['name'] }}</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $widget['data']->count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="{{ $widget['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
@endforeach
