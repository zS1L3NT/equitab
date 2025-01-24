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
            abort(500);
        }

        if (isset($value) && $transaction->products()->exists()) {
            $fail('This transaction\'s cost cannot be updated, the cost is calculated based on the products\' total cost.');
        }
    }
}
