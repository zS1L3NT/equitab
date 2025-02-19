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
        $product->updateQuietly(request(['owers']));

        $product->transaction()->increment('cost', $product->cost);

        event(new ProductCreated($product));
    }

    public function updating(Product $product): void
    {
        $product->transaction()->increment('cost', $product->cost - $product->getOriginal()['cost']);
    }

    public function updated(Product $product): void
    {
        event(new ProductUpdated($product));
    }

    public function deleted(Product $product): void
    {
        $product->transaction()->decrement('cost', $product->cost);

        event(new ProductDeleted($product));
    }
}
