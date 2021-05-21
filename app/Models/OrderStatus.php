<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';
    protected $fillable = [
        'order_id',
        'order_status',
        'status_remarks'
    ];

    public function orderDetail()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
