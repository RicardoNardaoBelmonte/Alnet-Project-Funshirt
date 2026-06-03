<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'name';

    public $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'code',
        'custom',
    ];

    public function tshirts()
    {
        return $this->belongsToMany(Tshirt::class, 'tshirt_color', 'color', 'tshirt_id', 'name', 'id');
    }
}
