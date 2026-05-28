<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    protected $fillable = [
        'customer_id',
        'category_id',
        'name',
        'description',
        'image_url',
        'price',
        'sales_count',
        'custom',
    ];

    protected $casts = [
        'sales_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'tshirt_color');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
