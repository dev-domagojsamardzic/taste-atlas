<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithParameter implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Allowed values are
        $allowed = [ 'ingredients', 'category', 'tags' ];

        // Explode value to get array
        $values = explode(',', $value);

        if(!empty($values)) {

            // Check validity of every value in with input
            foreach($values as $val) {

                if(!in_array($val, $allowed)) {
                    $fail('You entered invalid :attribute attribute. Valid values are: ' . implode(',', $allowed));
                    return;
                }
            }
        }
    }
}
