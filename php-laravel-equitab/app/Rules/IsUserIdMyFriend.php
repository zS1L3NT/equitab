<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsUserIdMyFriend implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var \App\Models\User $user*/
        $user = auth()->user();

        if (!$user) {
            return;
        }

        if ($user->id != $value && $user->friends()->where('friend_id', $value)->doesntExist()) {
            $fail('This user either doesn\'t exist or isn\'t one of your friends.');
        }
    }
}
