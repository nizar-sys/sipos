<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'kode_produk' => 8374238332,
                'nama_produk' => 'Produk 1',
                'slug_produk' => 'produk-1',
                'kategori_produk' => 'minuman',
                'harga_produk' => 40000,
                'diskon_produk' => 0,
                'stok_produk' => 200,
                'gambar_produk' => 'prod1.jpg',
            ],
            [
                'kode_produk' => 763478233,
                'nama_produk' => 'Produk 2',
                'slug_produk' => 'produk-2',
                'kategori_produk' => 'barang',
                'harga_produk' => 50000,
                'diskon_produk' => 0,
                'stok_produk' => 100,
                'gambar_produk' => 'prod2.jpg',
            ],
            [
                'kode_produk' => 7834322,
                'nama_produk' => 'Produk 3',
                'slug_produk' => 'produk-3',
                'kategori_produk' => 'barang',
                'harga_produk' => 30000,
                'diskon_produk' => 0,
                'stok_produk' => 500,
                'gambar_produk' => 'prod3.jpg',
            ],
        ];
        foreach ($data as $key => $value) {
            Produk::create($value);
        }
    }
}
