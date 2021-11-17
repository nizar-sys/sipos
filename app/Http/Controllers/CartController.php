<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\Snap;
use App\Http\Traits\ReturnTrait;
use App\Models\Cart;
use App\Models\Produk;
use App\Models\Transaksi;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use ReturnTrait;
    public function addToCart(Request $request)
    {
        try {

            $user = $request->user();
            $cart = Cart::all()
                ->where('user_id', $user->id)
                ->where('product_id', $request->id_produk)
                ->where('status', 'oncart');
            $product = Produk::all()->where('id', $request->id_produk)->first();
            $msg = '';

            if ($cart->isEmpty()) {
                $qty = 1;
                $cart =  Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->id_produk,
                    'qty' => $qty,
                    'status' => 'oncart',
                    'subtotal' => $request->harga * $qty,
                    'created_at' => date(now())
                ]);
                $msg  = 'Produk berhasil disimpan di keranjang';
            } else {
                $cart = $cart->first();
                $cart->update([
                    'subtotal' => ($cart->qty + 1) * $request->harga,
                    'qty' => $cart->qty + 1,
                    'updated_at' => date(now())
                ]);
                $msg = 'Produk sudah ada di keranjang';
            }

            $data['carts'] = $cart;

            if ($request->ajax()) {
                return $this->success($data, $msg);
            }

            return $cart;
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }


    public function updateQty(Request $request)
    {
        try {

            $user = $request->user();
            $data['carts'] = Cart::all()
                ->where('id', $request->id)
                ->where('status', 'oncart')
                ->first();

            $cart = $data['carts'];
            $product = $cart->product->get()->first();

            if (intval($request->newQty) > $product->stok_produk) {
                if ($request->ajax()) {
                    return $this->error('Stok kurang');
                }
                return back()->with('error', 'Stok kurang');
            }

            $cart->update([
                'subtotal' => ($product->harga_produk - $product->harga_produk * $product->diskon_produk / 100) * $request->newQty,
                'qty' => $request->newQty,
                'updated_at' => date(now())
            ]);

            if ($request->ajax()) {
                return $this->success($data, 'Success ubah katalog');
            }

            return $data;
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return back()->with('error', "Error " . $th->getMessage());
        }
    }

    public function deleteCart(Request $request)
    {
        try {
            $data['carts'] = Cart::all()
                ->where('id', $request->id)
                ->where('status', 'oncart')
                ->first();
            $cart = $data['carts'];

            $cart->delete();

            if ($request->ajax()) {
                return $this->success($data, 'Barang terhapus di keranjang');
            }

            return back()->with('success', "Barang terhapus di keranjang");
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function checkout(Request $request)
    {
        try {

            $cartsId = explode(',', $request->cartsId);
            $data['carts'] = Cart::whereIn('id', $cartsId);

            $newTransaction = Transaksi::create([
                'user_detail' => Auth::user()->id,
                'detail_transaksi' => rand(100000, 999999),
                'total_transaksi' => $request->total_transaksi,
                'status_transaksi' => 'menunggu pembayaran',
                'tanggal_transaksi' => date('Y-m-d')
            ]);

            if(!$newTransaction){
                if($request->ajax()){
                    return $this->error('Transaksi gagal');
                }
                return back()->with('eror', 'Transaksi gagal');
            }

            $data['carts']->update([
                'status' => 'ordered',
                'code_transaksi' => $newTransaction['detail_transaksi'],
                'updated_at' => date(now())
            ]);

            if ($request->ajax()) {
                return $this->success($data, 'Transaksi berhasil, silakan lakukan pembayaran');
            }

            // return $cartsId;
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function getSnapToken(Request $req){

        $item_list = array();
        $amount = 0;
        Config::$serverKey = base64_encode('SB-Mid-server-l1yAaWY7IVxOmjRC93NMKCzy:');
        if (!isset(Config::$serverKey)) {
            return "Please set your payment server key";
        }
        Config::$isSanitized = true;

        // Enable 3D-Secure
        Config::$is3ds = true;
        
        // Required

         $item_list[] = [
                'id' => "111",
                'price' => 20000,
                'quantity' => 1,
                'name' => "Majohn"
        ];

        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 20000, // no decimal allowed for creditcard
        );


        // Optional
        $item_details = $item_list;

        // Optional
        $billing_address = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Manggis 90",
            'city'          => "Jakarta",
            'postal_code'   => "16601",
            'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );

        // Optional
        $customer_details = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'email'         => "andri@litani.com",
            'phone'         => "081122334455",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        // Optional, remove this to display all available payment methods
        $enable_payments = array();

        // Fill transaction details
        $transaction = array(
            'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        // return $transaction;
        try {
            $snapToken = Snap::getSnapToken($transaction);
            return response()->json($snapToken);
            // return ['code' => 1 , 'message' => 'success' , 'result' => $snapToken];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0 , 'message' => 'failed'];
        }

    }
}
