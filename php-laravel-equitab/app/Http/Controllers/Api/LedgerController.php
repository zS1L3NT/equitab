<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LedgerResource;
use App\Models\Ledger;
use App\Rules\HasMyUserId;
use App\Rules\IsUserIdMyFriend;
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
            'currency' => 'required|array',
            'currency.code' => 'required|exists:currencies,code',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'users' => ['required', 'array', 'min:1', new HasMyUserId],
            'users.*' => 'required|array',
            'users.*.id' => ['required', 'integer', new IsUserIdMyFriend],
        ]);

        $ledger = Ledger::create($data);
        $ledger->load('users');

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
            'currency' => 'array',
            'currency.code' => 'present_with:currency|exists:currencies,code',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'users' => 'array|min:1',
            'users.*' => 'present_with:users|array',
            'users.*.id' => ['present_with:users', 'integer', new IsUserIdMyFriend]
        ]);

        $ledger->update($data);
        $ledger->refresh();

        return [
            'message' => 'Ledger updated.',
            'data' => new LedgerResource($ledger)
        ];
    }

    public function destroy(Ledger $ledger)
    {
        $ledger->delete();

        return [
            'message' => 'Ledger deleted.'
        ];
    }
}
