<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    // code (CSS value) is the primary key — not auto-increment
    protected $primaryKey = 'code';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'code',
        'name',
        'custom',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'color_code', 'code');
    }
}