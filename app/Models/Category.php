<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'name';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'image_url',
        'custom',
    ];

    public function tshirts()
    {
        return $this->hasMany(Tshirt::class, 'category', 'name');
    }
}
