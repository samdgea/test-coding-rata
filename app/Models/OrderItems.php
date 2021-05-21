<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'order_items_id',
        'qty'
    ];
    protected $with = ['itemDetail'];
    protected $appends = ['total_price'];

    protected $hidden = [
        'id',
        'order_id',
        'order_items_id',
        'qty',
        'created_at',
        'updated_at'
    ];

    public function itemDetail()
    {
        return $this->hasOne(Item::class, 'id', 'order_items_id');
    }

    public function getTotalPriceAttribute()
    {
        return (int)((int)$this->qty*(int)$this->itemDetail->item_price);
    }
}
