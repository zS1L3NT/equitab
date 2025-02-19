<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Ledger;
use App\Models\Transaction;
use App\Rules\DoTransactionOwerAggregatesCancelOutCost;
use App\Rules\HasNoProducts;
use App\Rules\IsLedgerUserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index(Ledger $ledger)
    {
        $ledger->load('users');

        return TransactionResource::collection($ledger->transactions()->with('owers')->withCount('products')->paginate());
    }

    public function store(Request $request, Ledger $ledger)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'cost' => 'required|decimal:0,4|min:0',
            'location' => 'string',
            'datetime' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'payer' => 'required|array',
            'payer.id' => ['required', 'integer', new IsLedgerUserId],
            'owers' => ['required', 'array', 'min:1', new DoTransactionOwerAggregatesCancelOutCost],
            'owers.*' => 'required|array',
            'owers.*.id' => ['required', 'integer', new IsLedgerUserId],
            'owers.*.aggregate' => 'required|decimal:0,4'
        ]);

        $transaction = $ledger->transactions()->create($data);
        $transaction->refresh();

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
            'cost' => ['decimal:0,4', 'min:0', new HasNoProducts],
            'location' => 'string',
            'datetime' => 'date',
            'category_id' => 'exists:categories,id',
            'payer' => 'array',
            'payer.id' => ['present_with:payer', 'integer', new IsLedgerUserId],
            'owers' => ['array', 'min:1', new DoTransactionOwerAggregatesCancelOutCost],
            'owers.*' => 'present_with:owers|array',
            'owers.*.id' => ['present_with:owers', 'integer', new IsLedgerUserId],
            'owers.*.aggregate' => ['present_with:owers', 'decimal:0,4', new HasNoProducts]
        ]);

        $transaction->update($data);
        $transaction->refresh();

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
