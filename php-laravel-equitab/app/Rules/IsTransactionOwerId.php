<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsTransactionOwerId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var \App\Models\Transaction $transaction */
        $transaction = request()->route('transaction');

        if (!$transaction) {
            return;
        }

        if ($transaction->owers()->where('users.id', $value)->doesntExist()) {
            $fail('This user either doesn\'t exist or is not an ower of the transaction.');
        }
    }
}
