<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'order_receiver',
        'order_receiver_address',
        'payments_id'
    ];
    protected $with = ['paymentDetail'];

    protected static function boot()
    {
        static::creating(function($table) {
            $table->order_number = 'INV-' . date('Ym') . '-' . rand(100000, 999999);
        });
    }

    public function paymentDetail()
    {
        return $this->hasOne(Payment::class, 'id', 'payments_id');
    }

    public function orderProgress()
    {
        return $this->hasMany(OrderStatus::class, 'order_id', 'id');
    }
}
