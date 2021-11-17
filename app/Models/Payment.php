<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'tb_payments';
    protected $fillable = [
        "trx_code",
        "change_payment",
        "total_payment",
        "proof_payment",
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaksi::class, 'trx_code', 'detail_transaksi');
    }
}
