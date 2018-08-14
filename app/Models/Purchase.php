<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'product_id',
        'purchase_price',
        'sale_price',
        'purchased_by',
        'payment_status_id',
        'purchased_at'
    ];
}
