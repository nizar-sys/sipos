<?php

namespace App\Http\Controllers\route;

use App\Http\Controllers\Controller;
use App\Http\Traits\ReturnTrait;
use App\Models\ActivityLog;
use App\Models\Cart;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RouteContoller extends Controller
{
    use ReturnTrait;
    public function home()
    {
        return view('dashboard.home');
    }

    public function forgotPass()
    {
        return view('auth.forgotPass');
    }

    public function profile()
    {
        $data = [
            'activities' => ActivityLog::all()->where('causer_id', Auth::user()->id)->sortByDesc('id')->take(5),
        ];
        return view('dashboard.profile.index', compact('data'));
    }

    public function dataPengguna()
    {
        try {
            $data = [
                'users' => DB::table('tb_users')->orderByDesc('id')->paginate(10),
            ];
            return view('dashboard.data.users.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }


    public function logout()
    {
        try {

            Auth::logout();

            return redirect('/')->with('success', 'Logout successfully');
        } catch (\Throwable $th) {
            return with('error', 'Error ' . $th->getMessage());
        }
    }

    public function download(Request $request, $filename = null)
    {
        try {

            $path = storage_path() . "/app/public/fileUploads/$filename";
            return response()->download($path);
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function productList()
    {
        try {

            $data = [
                'products' => Produk::latest()->paginate(10),
            ];

            if (Auth::user()->role == '0') {
                return view('dashboard.products.index', compact('data')); // view user
            }

            return view('dashboard.data.products.index', compact('data')); // view admin

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function productDetail($role, $kodeProduk)
    {
        try {

            $product = Produk::all()->where('kode_produk', $kodeProduk)->first();

            if (request()->ajax()) {
                return $this->success($product, 'Product found');
            }

            if ($role != 'admin') {
                // for user view
            }
        } catch (\Throwable $th) {

            if (request()->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function myCart($role, $id)
    {
        try {

            $data['carts'] = Cart::latest()->with('product')->where('user_id', $id)->where('status', 'oncart')->get();

            if (request()->ajax()) {
                return $this->success($data, 'Success');
            }

            return $data['carts'];
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function transactionList()
    {
        try {
            $transactionModel = new Transaksi();
            $data = [];

            $data['transactions'] = $transactionModel->latest()->paginate(10);

            if(Auth::user()->role == '0'){
                $data['transactions'] = $transactionModel->where('user_detail', Auth::user()->id)->latest()->paginate(10);

                // dd($data['transactions']);
                return view('dashboard.transaksi.index', compact('data'));
            }

            if (request()->ajax()) {
                return $this->success($data, 'Success');
            }
            return view('dashboard.data.transaksi.index', compact('data'));
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function transactionDetail($role, $codeTransaksi)
    {
        try {
            $transaksi = new Transaksi();
            $codeTransaksi = base64_decode($codeTransaksi);

            $data['transactions'] = $transaksi->where('detail_transaksi', $codeTransaksi)->first();

            
            return view('dashboard.data.transaksi.detail', compact('data'));
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }


    public function receiptTrx($role, $codeTransaksi)
    {
        try {
            $transaksi = new Transaksi();
            $codeTransaksi = base64_decode($codeTransaksi);

            $data['transactions'] = $transaksi->where('detail_transaksi', $codeTransaksi)->first();

            
            return view('dashboard.receipts.transaksi', compact('data'));
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
