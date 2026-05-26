<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image_url',
        'custom',
    ];

    public function tshirts()
    {
        return $this->hasMany(Tshirt::class);
    }
}
