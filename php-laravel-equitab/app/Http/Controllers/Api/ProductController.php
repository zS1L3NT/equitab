<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Ledger;
use App\Models\Product;
use App\Models\Transaction;
use App\Rules\IsProductIndexUnique;
use App\Rules\IsTransactionOwer;
use Illuminate\Http\Request;
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

        $transaction->products()->create($data)->owers()->sync($data['ower_ids']);

        return response([
            'message' => 'Product created.'
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

        $product->update($data);

        return [
            'message'=> 'Product updated.',
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
