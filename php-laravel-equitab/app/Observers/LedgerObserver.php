<?php

namespace App\Observers;

use App\Events\LedgerCreated;
use App\Events\LedgerDeleted;
use App\Events\LedgerUpdated;
use App\Models\Ledger;

class LedgerObserver
{
    public function created(Ledger $ledger): void
    {
        event(new LedgerCreated($ledger));
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
