<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreProduct;
use App\Http\Requests\RequestUpdateProduct;
use App\Http\Traits\ReturnTrait;
use App\Imports\ProdukImport;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProdukController extends Controller
{
    use ReturnTrait;

    public function __construct()
    {
        $this->middleware('isAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('dashboard.data.products.create');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreProduct $request)
    {
        try {

            $validated = $request->validated();

            $imageProduk = explode('.', $validated['gambar_produk']->getClientOriginalName())[0] . '-' . time() . '.' . $validated['gambar_produk']->extension();

            $uploadImage = $validated['gambar_produk']->move(public_path('storage/productImgs'), $imageProduk);

            if (!$uploadImage) {
                if ($request->ajax()) {
                    return $this->error('Gambar gagal diunggah');
                }
                return redirect()->back()->with('error', 'Gambar gagal diunggah');
            }

            Produk::create([
                'kode_produk' => $validated['kode_produk'],
                'nama_produk' => Str::title($validated['nama_produk']),
                'slug_produk' => Str::slug($validated['nama_produk']),
                'kategori_produk' => Str::title($validated['kategori_produk']),
                'harga_produk' => $validated['harga_produk'],
                'diskon_produk' => $validated['diskon_produk'],
                'stok_produk' => $validated['stok_produk'],
                'gambar_produk' => $imageProduk,
            ]);
            activity()->log('Menambah data produk');

            if ($request->ajax()) {
                return $this->success(null, 'Berhasil tambah data produk');
            }

            return redirect()->route('product.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'user'])->with('success', 'Berhasil tambah data produk');
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(RequestUpdateProduct $request)
    {
        try {

            $validated = $request->validated();

            $product = Produk::findOrFail($request->id_produk);

            $product->update([
                'kode_produk' => $validated['kode_produk'],
                'nama_produk' => Str::title($validated['nama_produk']),
                'kategori_produk' => Str::title($validated['kategori_produk']),
                'harga_produk' => $validated['harga_produk'],
                'diskon_produk' => $validated['diskon_produk'],
                'stok_produk' => $validated['stok_produk'],
            ]);

            if ($request->ajax()) {
                return $this->success([
                    'product' => $product
                ], 'Berhasil ubah data produk');
            }
            return back()->with('success', 'Berhasil ubah data produk');
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        //
    }

    public function updateImgProd(Request $request)
    {
        try {
            $request->validate([
                'newImgProd' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20348',
            ]);

            $imageName = 'Produk -' . time() . '.' . $request->newImgProd->extension();


            $request->newImgProd->move(storage_path('app/public/productImgs'), $imageName);

            $product = Produk::all()->where('kode_produk', $request->kodeProduk)->first();

            if ($product->gambar_produk != 'emptyProd.jpg') {
                Storage::disk('public')->delete("/productImgs/$product->gambar_produk");
            }

            $product->update([
                'gambar_produk' => $imageName,
                'updated_at' => date(now())
            ]);


            if ($request->ajax()) {
                return $this->success(null, 'success');
            }

            return redirect()->route('product.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'user'])->with('success', 'Berhasil ubah foto produk');
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->route('product.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'user'])->with('error', 'Error ' . $th->getMessage());
        }
    }


    public function createProdukExcel(Request $request)
    {
        try {


            $fileName = explode('.', $request->file('file')->getClientOriginalName())[0] . '-' . time() . '.' . $request->file('file')->extension();

            Excel::import(new ProdukImport,  $request->file('file'));

            if ($request->ajax()) {
                return $this->success(null, 'Berhasil import data produk');
            }

            return redirect()->route('product.index', ['role' => Auth::user()->role == '1' ? 'admin' : 'user'])->with('success', 'Berhasil import data produk');
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {

            $arrProdId = $request->selectedData;
            $arrProdId = explode(',', $arrProdId);

            $products = Produk::whereIn('id', $arrProdId);

            $products->delete();

            activity()->log('Menghapus beberapa data produk');

            if ($request->ajax()) {
                return $this->success(null, 'Berhasil hapus beberapa data produk');
            }

            return redirect()->back()->with('success', 'Berhasil hapus beberapa data produk');
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
