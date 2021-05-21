<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'payment_method',
        'payment_proof',
        'payment_status'
    ];

    public function orderDetail()
    {
        return $this->belongsTo(Order::class, 'id', 'payments_id');
    }
}
