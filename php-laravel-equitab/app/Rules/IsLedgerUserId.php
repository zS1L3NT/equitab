<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsLedgerUserId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var \App\Models\Ledger $ledger */
        $ledger = request()->route('ledger');

        if (!$ledger) {
            abort(500);
        }

        if ($ledger->users()->where('users.id', $value)->doesntExist()) {
            $fail('This user either doesn\'t exist or doesn\'t have permission to access this ledger.');
        }
    }
}
