<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transactions';
    protected $fillable = [
        'user_detail',
        'detail_transaksi',
        'total_transaksi',
        'status_transaksi',
        'tanggal_transaksi'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'code_transaksi', 'detail_transaksi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_detail', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'detail_transaksi', 'trx_code');
    }
}
