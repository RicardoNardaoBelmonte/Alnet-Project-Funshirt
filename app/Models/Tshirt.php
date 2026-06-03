<?php

namespace App\Models;

use Database\Factories\TshirtFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tshirt extends Model
{
    /** @use HasFactory<TshirtFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'category',
        'name',
        'description',
        'image_url',
        'price',
        'sales_count',
        'custom',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sales_count' => 'integer',
    ];

    public function categoryModel()
    {
        return $this->belongsTo(Category::class, 'category', 'name');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'tshirt_color', 'tshirt_id', 'color', 'id', 'name');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
