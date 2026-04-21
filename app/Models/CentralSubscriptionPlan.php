<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralSubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = ['name', 'price', 'interval', 'description', 'features', 'is_active', 'yookassa_offer_id'];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
