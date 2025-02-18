<?php

namespace App\Observers;

use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
use App\Models\Product;

class ProductObserver
{
    public function created(Product $product): void
    {
        // TODO Increment all product ower aggregates on transaction ower aggregates
        event(new ProductCreated($product));
    }

    public function updating(Product $product): void
    {
        // TODO Decrement all product ower aggregates on transaction ower aggregates
    }

    public function updated(Product $product): void
    {
        // TODO Increment all product ower aggregates on transaction ower aggregates
        event(new ProductUpdated($product));
    }

    public function deleted(Product $product): void
    {
        // TODO Decrement all product ower aggregates on transaction ower aggregates
        event(new ProductDeleted($product));
    }
}
