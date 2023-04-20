<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class CategoryParameter implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == null) {
            $fail('The :attribute attribute cannot be empty.');
            return;
        }

        // Check if the value is 'NULL' or '!NULL'
        if ($value === 'NULL' || $value === '!NULL') {
            return;
        }

        // Check if only one category is provided
        $categoryArray = explode(',', $value);

        if (count($categoryArray) > 1) {
            $fail('Only one category ID is allowed.');
            return;
        }

        // Check if the value is a valid category ID
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        if (!in_array($value, $categoryIds)) {
            $fail('The :attribute parameter must be a valid category ID, NULL or !NULL.');
            return;
        }

        return;
    }
}
