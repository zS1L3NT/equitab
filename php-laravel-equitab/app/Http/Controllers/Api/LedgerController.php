<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LedgerResource;
use App\Events\LedgerChanged;
use App\Models\Ledger;
use App\Rules\HasMyUser;
use App\Rules\IsMyFriend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LedgerController extends Controller
{
    public function index()
    {
        return LedgerResource::collection(auth()->user()->ledgers()->withPivot('aggregate')->paginate());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'currency_code' => 'required|exists:currencies,code',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'user_ids' => ['required', 'array', 'min:1', new HasMyUser],
            'user_ids.*' => ['required', 'integer', new IsMyFriend]
        ]);

        $ledger = DB::transaction(function () use ($data) {
            $ledger = Ledger::create($data);
            $ledger->users()->sync($data['user_ids']);
            return $ledger;
        });

        $event = new LedgerChanged($ledger->id);
        $event->new = json_decode($ledger->toJson(), true);
        event($event);

        return response([
            'message' => 'Ledger created.',
            'data' => new LedgerResource($ledger)
        ], Response::HTTP_CREATED);
    }

    public function show(Ledger $ledger)
    {
        return [
            'data' => new LedgerResource($ledger)
        ];
    }

    public function update(Request $request, Ledger $ledger)
    {
        $data = $request->validate([
            'name' => 'string',
            'currency_code' => 'exists:currencies,code',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'user_ids' => 'array|min:1',
            'user_ids.*' => ['integer', new IsMyFriend]
        ]);

        $event = new LedgerChanged($ledger->id);
        $event->old = json_decode($ledger->toJson(), true);

        $ledger->update($data);

        $ledger->refresh();
        $event->new = json_decode($ledger->toJson(), true);
        if ($event->old != $event->new) event($event);

        return [
            'message' => 'Ledger updated.',
            'data' => new LedgerResource($ledger)
        ];
    }

    public function destroy(Ledger $ledger)
    {
        $event = new LedgerChanged($ledger->id);
        $event->old = json_decode($ledger->toJson(), true);

        $ledger->delete();

        event($event);

        return [
            'message' => 'Ledger deleted.'
        ];
    }
}
