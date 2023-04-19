<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LanguageParameter implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $locales = config('translatable.locales');

        if (!in_array($value, $locales)) {
            $fail('The :attribute must be a valid language. Allowed language codes are: '. implode(',', config('translatable.locales')));
        }
    }
}
