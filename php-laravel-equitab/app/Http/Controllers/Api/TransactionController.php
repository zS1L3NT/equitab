<?php

namespace App\Http\Controllers\Api;

use App\Events\TransactionChanged;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Ledger;
use App\Models\Transaction;
use App\Rules\IsLedgerUserAggregatesEqualToCost;
use App\Rules\IsNotProductUser;
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
            'cost' => 'required|decimal:0,4',
            'location' => 'string',
            'datetime' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'payer' => 'required|array',
            'payer.id' => ['required', 'integer', new IsLedgerUserId],
            'owers' => ['required', 'array', 'min:1', new IsLedgerUserAggregatesEqualToCost],
            'owers.*' => 'required|array',
            'owers.*.id' => ['required', 'integer', new IsLedgerUserId],
            'owers.*.aggregate' => 'required|decimal:0,4'
        ]);

        $transaction = DB::transaction(function () use ($data, $ledger, &$transaction) {
            $transaction = $ledger->transactions()->create($data);
            $transaction->update(['payer' => $data['payer'], 'owers' => $data['owers']]);
            return $transaction;
        });

        $event = new TransactionChanged($ledger->id);
        $event->new = json_decode($transaction->toJson(), true);
        event($event);

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
            'cost' => ['decimal:0,4', new HasNoProducts],
            'location' => 'string',
            'datetime' => 'date',
            'category_id' => 'exists:categories,id',
            'payer' => 'array',
            'payer.id' => ['present_with:payer', 'integer', new IsLedgerUserId],
            'owers' => ['array', 'min:1', new IsLedgerUserAggregatesEqualToCost],
            'owers.*' => 'present_with:owers|array',
            'owers.*.id' => ['present_with:owers', 'integer', new IsLedgerUserId],
            'owers.*.aggregate' => 'present_with:owers|decimal:0,4'
        ]);

        $event = new TransactionChanged($ledger->id);
        $event->old = json_decode($transaction->toJson(), true);

        $transaction->update($data);

        $transaction->refresh();
        $event->new = json_decode($transaction->toJson(), true);
        if ($event->old != $event->new) event($event);

        return [
            'message' => 'Transaction updated.',
            'data' => new TransactionResource($transaction)
        ];
    }

    public function destroy(Ledger $ledger, Transaction $transaction)
    {
        $event = new TransactionChanged($ledger->id);
        $event->old = json_decode($transaction->toJson(), true);

        $transaction->delete();

        event($event);

        return [
            'message' => 'Transaction deleted.'
        ];
    }
}
