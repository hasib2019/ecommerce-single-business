<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        // core existing fields (kept minimal since not shown)
        'paymentAmount', 'status', 'deliveryCharge', 'courier_id', 'memo',
        // new columns you mentioned
        'courier_name', 'courier_store_id', 'consignment_id', 'merchant_order_id', 'order_status', 'courier_delivery_fee',
    ];
}
