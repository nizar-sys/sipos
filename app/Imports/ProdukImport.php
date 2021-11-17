<?php

namespace App\Imports;

use App\Models\Produk;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProdukImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function rules(): array
    {
        return [
            'kode_produk' => [
                'required',
                'integer',
                'unique:tb_products,kode_produk'
            ],
            'nama_produk' => [
                'required',
                'string',
            ],
            'kategori' => [
                'required',
                'string'
            ],
            'harga_produk' => [
                'required',
                'integer'
            ],
            'harga_diskon_produk' => [
                'required',
                'integer'
            ],
            'stok_produk' => [
                'required',
                'integer'
            ],
        ];
    }

    public function model(array $row)
    {
        return new Produk([
            'kode_produk' => intval($row['kode_produk']),
            'nama_produk' => Str::title($row['nama_produk']),
            'slug_produk' => Str::slug($row['nama_produk']),
            'kategori_produk' => Str::title($row['kategori']),
            'harga_produk' => intval($row['harga_produk']),
            'diskon_produk' => intval($row['harga_diskon_produk']),
            'stok_produk' => intval($row['stok_produk']),
            'gambar_produk' => 'emptyProd.jpg'
        ]);
    }
}
