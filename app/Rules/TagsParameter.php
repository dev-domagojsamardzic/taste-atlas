<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class TagsParameter implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if($value == null) {
            $fail('The :attribute parameter cannot be empty.');
            return;
        }

        // Get array of tag id's
        $tagIdArray = DB::table('tags')->pluck('id')->toArray();

        // Check if the value is a single number

        if (preg_match('/^\d+$/', $value)) {

            if (!in_array($value, $tagIdArray)) {
                $fail('The :attribute parameter must be a valid tag ID or a comma separated list of valid tag IDs.');
                return;
            }
        }
        // Check if the value is a comma separated list of numbers
        else {

            $tags = explode(',', $value);

            foreach ($tags as $tagId) {

                if (!in_array($tagId, $tagIdArray)) {
                    $fail('The :attribute parameter must be a valid tag ID or a comma separated list of valid tag IDs.');
                    return;
                }
            }
        }
    }
}
