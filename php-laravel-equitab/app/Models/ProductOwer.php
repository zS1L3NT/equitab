<?php

namespace App\Models;

use App\Observers\ProductOwerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([ProductOwerObserver::class])]
class ProductOwer extends Pivot
{
    public $timestamps = null;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ower()
    {
        return $this->belongsTo(User::class, 'ower_id');
    }
}
