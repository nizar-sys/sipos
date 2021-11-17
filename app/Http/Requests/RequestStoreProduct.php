<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_produk' => 'required|numeric|min:7',
            'nama_produk' => 'required|',
            'kategori_produk' => 'required',
            'harga_produk' => 'required|numeric',
            'diskon_produk' => 'nullable|numeric',
            'stok_produk' => 'required|numeric',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20348'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Kolom harus diisi',
            '*.numeric' => 'Karakter harus diisi angka',
            'kode_produk.min' => 'Kode Produk harus lebih dari :min karakter',
            'gambar_produk.max' => 'Gambar Produk melebihi batas maksimal'
        ];
    }
}
