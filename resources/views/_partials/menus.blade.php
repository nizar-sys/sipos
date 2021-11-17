@php
$user = Auth::user();
$menus = [
    [
        'menu' => 'Dashboard',
        'url' => route('home', ['role' => $user->role == '1' ? 'admin' : 'users']),
        'icon' => 'ni ni-tv-2 text-primary',
        'sub_menu' => [
            $user->role == '1'
                ? [
                    'submenu' => 'Data Pengguna',
                    'suburl' => route('user.list', ['role' => $user->role == '1' ? 'admin' : 'users']),
                    'subicon' => 'fas fa-users text-primary',
                ]
                : null,
            [
                'submenu' => 'Data Produk',
                'suburl' => route('product.index', ['role' => $user->role == '1' ? 'admin' : 'users']),
                'subicon' => 'ni ni-bag-17 text-primary',
            ],
        ],
    ],
    [
        'menu' => 'Profile',
        'url' => route('profile', ['slug' => $user->slug]),
        'icon' => 'ni ni-single-02 text-yellow',
        'sub_menu' => 0,
    ],
    [
        'menu' => 'Transaksi',
        'url' => route('transaction.index', ['role' => $user->role == '1' ? 'admin' : 'users']),
        'icon' => 'fas fa-chart-line text-info',
        'sub_menu' => 0,
    ],
];
@endphp

@foreach ($menus as $menu)
    @if ($menu != null)
        <li class="nav-item">
            <a class="nav-link" href="{{ $menu['url'] }}">
                <i class="{{ $menu['icon'] }}"></i>
                <span class="nav-link-text">{{ $menu['menu'] }}</span>
            </a>
            @if ($menu['sub_menu'] != 0)
                <ul class="nav nav-treeview">
                    @foreach ($menu['sub_menu'] as $submenu)
                        @if ($submenu != null)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $submenu['suburl'] }}">
                                    <i class="{{ $submenu['subicon'] }}"></i>
                                    <span class="nav-link-text">{{ $submenu['submenu'] }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
@endforeach
