<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LedgerResource;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LedgerController extends Controller
{
    public function index()
    {
        return LedgerResource::collection(auth()->user()->ledgers()->paginate());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'currency' => 'required', // TODO get full list of currencies
            'picture_file' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ledger = Ledger::create($data);
        $ledger->users()->attach(auth()->user());

        return response([
            'message' => 'Ledger created!'
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
            'currency' => 'prohibited', // TODO update currency logic
            'picture_file' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ledger->update($data);

        return [
            'message' => 'Ledger updated!'
        ];
    }

    public function destroy(Ledger $ledger)
    {
        $ledger->delete();

        return [
            'message' => 'Ledger deleted!'
        ];
    }
}
