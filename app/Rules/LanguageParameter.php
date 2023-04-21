<?php

namespace App\Rules;

use App\Models\Language;
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
        $locales = Language::pluck('code')->toArray();

        if (!in_array($value, $locales)) {
            $fail('The :attribute must be a valid language. Allowed language codes are: '. implode(',', config('translatable.locales')));
        }
    }
}
