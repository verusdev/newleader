<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralPayment extends Model
{
    protected $table = 'central_payments';

    protected $fillable = [
        'subscription_id', 'payment_method', 'yookassa_payment_id',
        'amount', 'status', 'response_data',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
