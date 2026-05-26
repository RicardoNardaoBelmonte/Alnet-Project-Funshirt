<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name',
        'code',
        'custom',
    ];

    public function tshirts()
    {
        return $this->belongsToMany(Tshirt::class, 'tshirt_color');
    }
}
