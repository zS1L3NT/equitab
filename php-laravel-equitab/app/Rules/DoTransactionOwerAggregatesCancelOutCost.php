<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DoTransactionOwerAggregatesCancelOutCost implements ValidationRule
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

        if (!$ledger || !is_array($value)) {
            abort(500);
        }

        if (count(array_filter($value, fn($o) => !isset($o['id']) || !isset($o['aggregate']))) > 0) {
            return;
        }

        $cost = request('cost') ?: $ledger->cost;
        $aggregates = array_sum(array_map(fn($o) => $o['aggregate'], $value));
        if (-$aggregates != $cost) {
            $fail('The ower aggregates do not cancel out the transaction cost!');
        }
    }
}
