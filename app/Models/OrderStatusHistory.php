<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Delivery status change er log — order je status e kokhon gelo seta rakhe,
 * customer tracking timeline e date/time soho dekhate hoy.
 */
class OrderStatusHistory extends Model
{
    protected $fillable = ['order_id', 'status'];
}
