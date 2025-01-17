<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Ledger;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index(Ledger $ledger)
    {
        return TransactionResource::collection($ledger->transactions()->paginate());
    }

    public function store(Request $request, Ledger $ledger)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'string',
            'datetime' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'payer_id' => ['required', fn($p, $v, $f) => $ledger->users()->where('users.id', $v)->exists() ? null : $f('This user either doesn\'t exist or doesn\'t have permission to access this ledger.')],
            'cost' => 'required|decimal:0,4',
            'currency' => 'required|string', // TODO check valid currency
            'rate' => 'required|decimal:0,6',
        ]);

        $ledger->transactions()->create($data);

        return response([
            'message' => 'Transaction created!'
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
            'location' => 'string',
            'datetime' => 'date',
            'category_id' => 'exists:categories,id',
            'payer_id' => fn($p, $v, $f) => $ledger->users()->where('users.id', $v)->exists() ? null : $f('This user either doesn\'t exist or doesn\'t have permission to access this ledger.'),
            'cost' => 'decimal:0,4',
            'currency' => 'string', // TODO check valid currency
            'rate' => 'decimal:0,6',
        ]);

        $transaction->update($data);

        return [
            'message'=> 'Transaction updated.',
        ];
    }

    public function destroy(Ledger $ledger, Transaction $transaction)
    {
        $transaction->delete();

        return [
            'message' => 'Transaction deleted!'
        ];
    }
}
