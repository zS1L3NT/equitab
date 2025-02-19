<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasNoProducts implements ValidationRule
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

        if (isset($value) && request()->exists('owers') && $transaction->products()->exists()) {
            $fail("The transaction's $attribute field cannot be updated, it is calculated based on the products.");
        }
    }
}
