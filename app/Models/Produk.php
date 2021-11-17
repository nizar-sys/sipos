<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tb_products';
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'slug_produk',
        'kategori_produk',
        'harga_produk',
        'diskon_produk',
        'stok_produk',
        'gambar_produk',
    ];
}
