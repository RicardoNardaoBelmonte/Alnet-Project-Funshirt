<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'tshirt_id',
        'size',
        'quantity',
        'unit_price',
        'custom',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tshirt()
    {
        return $this->belongsTo(Tshirt::class);
    }
}
