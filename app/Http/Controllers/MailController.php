<?php

namespace App\Http\Controllers;

use App\Http\Traits\ReturnTrait;
use App\Mail\MailSendInvoice;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    use ReturnTrait;
    public function sendReceipt($trxID, $email)
    {
        try {

            $trxID = base64_decode($trxID);

            $data['transactions'] = Transaksi::all()->where('detail_transaksi', $trxID)->first();

            Mail::to($email)->send(new MailSendInvoice($data));

            if (request()->ajax()) {
                return $this->success(null, 'Invoice berhasil dikirim melalui email.');
            }

            return back()->with('success', 'Invoice berhasil dikirim melalui email.');
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return $this->error('Error ' . $th->getMessage());
            }
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
