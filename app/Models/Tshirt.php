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
        'is_best_seller',
        'custom',
    ];

    protected $casts = [
        'is_best_seller' => 'boolean',
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
