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
        return $this->hasMany(Cart::class, 'transaksi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_detail', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'trx_code', 'id');
    }
}
