<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Ledger;
use App\Models\Product;
use App\Models\Transaction;
use App\Rules\IsProductIndexUnique;
use App\Rules\IsTransactionOwerId;
use App\Rules\DoProductOwerAggregatesCancelOutCost;
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
            'cost' => 'required|decimal:0,4|min:0',
            'owers' => ['required', 'array', 'min:1', new DoProductOwerAggregatesCancelOutCost],
            'owers.*' => 'required|array',
            'owers.*.id' => ['required', 'integer', new IsTransactionOwerId],
            'owers.*.aggregate' => 'required|decimal:0,4'
        ]);

        $product = $transaction->products()->create($data);
        $product->refresh();

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
            'cost' => 'decimal:0,4|min:0',
            'owers' => ['array', 'min:1', new DoProductOwerAggregatesCancelOutCost],
            'owers.*' => 'present_with:owers|array',
            'owers.*.id' => ['present_with:owers', 'integer', new IsTransactionOwerId],
            'owers.*.aggregate' => 'present_with:owers|decimal:0,4'
        ]);

        $product->update($data);
        $product->refresh();

        $product->unsetRelation('transaction');

        return [
            'message' => 'Product updated.',
            'data' => new ProductResource($product)
        ];
    }

    public function destroy(Ledger $ledger, Transaction $transaction, Product $product)
    {
        $product->delete();

        return [
            'message' => 'Product deleted.'
        ];
    }
}
