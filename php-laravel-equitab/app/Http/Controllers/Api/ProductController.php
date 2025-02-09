<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductChanged;
use App\Events\TransactionChanged;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TransactionResource;
use App\Models\Ledger;
use App\Models\Product;
use App\Models\Transaction;
use App\Rules\IsProductIndexUnique;
use App\Rules\IsTransactionOwer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(Ledger $ledger, Transaction $transaction)
    {
        return ProductResource::collection($transaction->products);
    }

    public function store(Request $request, Ledger $ledger, Transaction $transaction)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'index' => ['required', 'integer', new IsProductIndexUnique],
            'quantity' => 'required|integer',
            'cost' => 'required|decimal:0,4',
            'ower_ids' => 'required|array|min:1',
            'ower_ids.*' => ['required', 'integer', new IsTransactionOwer],
        ]);

        $tevent = new TransactionChanged($ledger->id);
        $tevent->old = json_decode($transaction->toJson(), true);

        $product = DB::transaction(function () use ($data, $transaction, &$product) {
            $total_cost = $data['quantity'] * $data['cost'];

            if ($transaction->products()->exists()) {
                /**
                 * Transaction already has products
                 * Keep the transaction's cost in sync with the products' total cost
                 */
                $transaction->increment('cost', $total_cost);
            } else {
                /**
                 * Adding the first product to a transaction
                 * Reset the transaction's cost to be the new product's total cost
                 */
                $transaction->update(['cost' => $total_cost]);
            }

            $product = $transaction->products()->create($data);
            $product->unsetRelation('transaction');
            $product->owers()->sync($data['ower_ids']);
            return $product;
        });

        $pevent = new ProductChanged($ledger->id);
        $pevent->new = json_decode($product->toJson(), true);
        event($pevent);

        $transaction->refresh();
        $tevent->new = json_decode($transaction->toJson(), true);
        event($tevent);

        return response([
            'message' => 'Product created.',
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    public function show(Ledger $ledger, Transaction $transaction, Product $product)
    {
        $product->load('transaction');

        return [
            'data' => new ProductResource($product),
        ];
    }

    public function update(Request $request, Ledger $ledger, Transaction $transaction, Product $product)
    {
        $data = $request->validate([
            'name' => 'string',
            'index' => ['integer', new IsProductIndexUnique],
            'quantity' => 'integer',
            'cost' => 'decimal:0,4',
            'ower_ids' => 'array|min:1',
            'ower_ids.*' => ['integer', new IsTransactionOwer],
        ]);

        $pevent = new ProductChanged($ledger->id);
        $pevent->old = json_decode($product->toJson(), true);

        $tevent = new TransactionChanged($ledger->id);
        $tevent->old = json_decode($transaction->toJson(), true);

        DB::transaction(function () use ($data, $transaction, $product) {
            $quantity = isset($data['quantity']) ? $data['quantity'] : $product->quantity;
            $cost = isset($data['cost']) ? $data['cost'] : $product->cost;
            $total_cost = $quantity * $cost;

            if ($total_cost != $product->total_cost) {
                /**
                 * Total cost updated via either quantity or cost
                 * Keep the transaction's cost in sync with the products' total costs
                 */
                $transaction->increment('cost', $total_cost);
            }

            $product->update($data);
            $product->unsetRelation('transaction');
        });

        $product->refresh();
        $pevent->new = json_decode($product->toJson(), true);
        if ($pevent->old != $pevent->new) event($pevent);

        $transaction->refresh();
        $tevent->new = json_decode($transaction->toJson(), true);
        if ($tevent->old != $tevent->new) event($tevent);

        return [
            'message' => 'Product updated.',
            'data' => new ProductResource($product)
        ];
    }

    public function destroy(Ledger $ledger, Transaction $transaction, Product $product)
    {
        $pevent = new ProductChanged($ledger->id);
        $pevent->old = json_decode($product->toJson(), true);

        $tevent = new TransactionChanged($ledger->id);
        $tevent->old = json_decode($transaction->toJson(), true);

        DB::transaction(function () use ($transaction, $product) {
            $product->delete();

            if ($transaction->products()->exists()) {
                /**
                 * Transaction still has products
                 * Keep the transaction's cost in sync with the products' total costs
                 */
                $transaction->decrement('cost', $product->total_cost);
            } else {
                /**
                 * Transaction has no more products after deleting the current one
                 * Reset the transaction's cost to be $0 by default
                 */
                $transaction->update(['cost' => 0]);
            }
        });

        event($pevent);

        $transaction->refresh();
        $tevent->new = json_decode($transaction->toJson(), true);
        if ($tevent->old != $tevent->new) event($tevent);

        return [
            'message' => 'Product deleted.'
        ];
    }
}
