<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsProductIndexUnique implements ValidationRule
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

        if ($transaction->products()->where('index', $value)->exists()) {
            $fail('That product index is already taken.');
        }
    }
}
