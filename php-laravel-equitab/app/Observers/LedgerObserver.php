<?php

namespace App\Observers;

use App\Events\LedgerDeleted;
use App\Events\LedgerUpdated;
use App\Models\Ledger;

class LedgerObserver
{
    public function created(Ledger $ledger): void
    {
        $ledger->updateQuietly(request(['users']));
    }

    public function updated(Ledger $ledger): void
    {
        event(new LedgerUpdated($ledger));
    }

    public function deleted(Ledger $ledger): void
    {
        event(new LedgerDeleted($ledger));
    }
}
