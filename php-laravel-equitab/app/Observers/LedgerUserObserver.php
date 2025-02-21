<?php

namespace App\Observers;

use App\Events\LedgerUserCreated;
use App\Events\LedgerUserDeleted;
use App\Models\LedgerUser;

class LedgerUserObserver
{
    public function creating(LedgerUser $pivot): void
    {
        event(new LedgerUserCreated($pivot));
    }

    public function deleted(LedgerUser $pivot): void
    {
        event(new LedgerUserDeleted($pivot));
    }
}
