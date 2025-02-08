<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsNotProductUser implements ValidationRule
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

        if (!$transaction || !is_array($value) || !auth()->id()) {
            abort(500);
        }

        // Algorithm that is used internally to determine detached
        $detached = array_diff($transaction->owers()->pluck('id')->toArray(), $value);
        $exists = $transaction->products()->whereHas('owers', function ($query) use ($detached) {
            $query->whereIn('users.id', $detached);
        })->exists();

        if ($exists) {
            $fail('Cannot remove some users from this transaction, they are still attached to products!');
        }
    }
}
