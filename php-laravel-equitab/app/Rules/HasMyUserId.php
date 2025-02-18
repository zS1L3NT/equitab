<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasMyUserId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value) || !auth()->id()) {
            abort(500);
        }

        if (!in_array(auth()->id(), array_map(fn($u) => $u['id'], $value))) {
            $fail('Your user id must be present.');
        }
    }
}
