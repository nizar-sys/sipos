<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestPostPayment;
use App\Http\Traits\ReturnTrait;
use App\Mail\MailSendNotifSuccessTrx;
use App\Models\Payment;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TransaksiController extends Controller
{
    use ReturnTrait;


    public function payTransaction(RequestPostPayment $request)
    {
        try {
            $validated = $request->validated();

            $transaksi = Transaksi::all()->where('detail_transaksi', $validated['trx_code'])->first();


            $imageName = 'transfer-' . time() . '.' . $validated['bukti_tf']->extension();
            $validated['bukti_tf']->move(storage_path('app/public/fileUploads'), $imageName);

            $newPayment = Payment::create([
                'trx_code' => $validated['trx_code'],
                'change_payment' => (int)implode('', explode('.', $request->change_pay)),
                'total_payment' => (int)implode('', explode('.', $request->total_pay)),
                'proof_payment' => $imageName,
            ]);

            $transaksi->update([
                'status_transaksi' => 'dibayar',
                'updated_at' => date(now())
            ]);

            $carts = $transaksi->carts()->get();
            foreach ($carts as $cart) {
                $product = $cart->product->get()->first();
                if ($cart->qty > $product->stok_produk) {
                    return back()->with('error', 'Stok produk kurang, transaksi dibatalkan.');
                }
                $product->update([
                    'stok_produk' => $product->stok_produk - $cart->qty,
                ]);
            }


            if ($request->ajax()) {
                return $this->success(null, 'success');
            }

            return back()->with('success', 'Transaksi berhasil dibayar');
        } catch (\Throwable $th) {

            if ($request->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function cancelTransaction($trxID)
    {
        try {

            $trxID = base64_decode($trxID);

            $data['transactions'] = Transaksi::all()->where('detail_transaksi', $trxID)->first();

            $carts = $data['transactions']->carts()->get();
            foreach ($carts as $cart) {
                $product = $cart->product->get()->first();
                $product->update([
                    'stok_produk' => $product->stok_produk + $cart->qty,
                ]);
            }
            $data['transactions']->payment()->delete();
            $data['transactions']->carts()->delete();
            $data['transactions']->delete();
            if (request()->ajax()) {
                return $this->success(null, 'Transaksi berhasil dibatalkan');
            }

            return back()->with('success', 'Transaksi berhasil dibatalkan');
        } catch (\Throwable $th) {

            if (request()->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }


    public function successTransaction($trxID)
    {
        try {

            $trxID = base64_decode($trxID);

            $data['transactions'] = Transaksi::all()->where('detail_transaksi', $trxID)->first();
            $data['transactions']->update([
                'status_transaksi' => 'berhasil',
                'updated_at' => date(now())
            ]);

            Mail::to($data['transactions']->user->email)->send(new MailSendNotifSuccessTrx($data));
            if (request()->ajax()) {
                return $this->success(null, 'Transaksi berhasil dikonfirmasi');
            }

            return back()->with('success', 'Transaksi berhasil dikonfirmasi');
        } catch (\Throwable $th) {

            if (request()->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }

            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
