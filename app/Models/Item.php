<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'item_code',
        'item_name',
        'item_price'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
