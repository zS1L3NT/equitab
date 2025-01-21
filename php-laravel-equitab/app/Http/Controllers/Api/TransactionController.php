<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Ledger;
use App\Models\Transaction;
use App\Rules\IsLedgerUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index(Ledger $ledger)
    {
        return TransactionResource::collection($ledger->transactions()->withCount('products')->paginate());
    }

    public function store(Request $request, Ledger $ledger)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'cost' => 'required|decimal:0,4',
            'location' => 'string',
            'datetime' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'payer_id' => ['required', 'integer', new IsLedgerUser],
            'ower_ids' => 'required|array|min:1',
            'ower_ids.*' => ['required', 'integer', new IsLedgerUser],
        ]);

        $transaction = $ledger->transactions()->create($data);
        $transaction->owers()->sync($data['ower_ids']);

        return response([
            'message' => 'Transaction created.',
            'data' => new TransactionResource($transaction)
        ], Response::HTTP_CREATED);
    }

    public function show(Ledger $ledger, Transaction $transaction)
    {
        $transaction->load(['ledger', 'products']);

        return [
            'data' => new TransactionResource($transaction),
        ];
    }

    public function update(Request $request, Ledger $ledger, Transaction $transaction)
    {
        $data = $request->validate([
            'name' => 'string',
            'cost' => 'decimal:0,4',
            'location' => 'string',
            'datetime' => 'date',
            'category_id' => 'exists:categories,id',
            'payer_id' => ['integer', new IsLedgerUser],
            'ower_ids' => 'array|min:1',
            'ower_ids.*' => ['integer', new IsLedgerUser],
        ]);

        $transaction->update($data);

        return [
            'message' => 'Transaction updated.',
            'data' => new TransactionResource($transaction)
        ];
    }

    public function destroy(Ledger $ledger, Transaction $transaction)
    {
        $transaction->delete();

        return [
            'message' => 'Transaction deleted.'
        ];
    }
}
