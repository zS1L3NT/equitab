<?php

namespace App\Observers;

use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
use App\Models\Product;

class ProductObserver
{
    private function cascadeAggregation(Product $product, bool $undo = false)
    {
        if (!$undo) {
            $product->transaction->payer->pivot->increment('aggregate', $product->cost);
        } else {
            $product->transaction->payer->pivot->decrement('aggregate', $product->cost);
        }

        foreach ($product->owers as $ower) {
            $poaggregate = $ower->pivot;
            $toaggregate = $product->transaction->owers()->find($ower->id)->pivot;

            if (!$undo) {
                $toaggregate->increment('aggregate', $poaggregate);
            } else {
                $toaggregate->decrement('aggregate', $poaggregate);
            }
        }
    }

    public function created(Product $product): void
    {
        $this->cascadeAggregation($product);

        event(new ProductCreated($product));
    }

    public function updating(Product $product): void
    {
        $this->cascadeAggregation($product, true);
    }

    public function updated(Product $product): void
    {
        $this->cascadeAggregation($product);

        event(new ProductUpdated($product));
    }

    public function deleted(Product $product): void
    {
        $this->cascadeAggregation($product, false);

        event(new ProductDeleted($product));
    }
}
