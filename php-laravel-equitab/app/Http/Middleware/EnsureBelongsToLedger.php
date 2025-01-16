<?php

namespace App\Http\Middleware;

use App\Models\Ledger;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBelongsToLedger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Ledger|null $ledger */
        $ledger = $request->route('ledger');

        if ($ledger && !$ledger->users()->where('users.id', auth()->id())->exists()) {
            throw new ModelNotFoundException()->setModel(Ledger::class);
        }

        return $next($request);
    }
}
