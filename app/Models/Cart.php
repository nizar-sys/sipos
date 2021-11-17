<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'tb_carts';
    protected $guarded = [];


    protected $appends = [
        'product'
    ];
    
    
    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'id');
    }

    public function getProductAttribute()
    {
        return $this->product();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaksi::class, 'code_transaksi', 'detail_transaksi');
    }

}
