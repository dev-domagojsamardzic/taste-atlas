<?php

namespace App\Http\Requests;

use App\Rules\CategoryParameter;
use App\Rules\LanguageParameter;
use App\Rules\TagsParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class MealsIndexRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'lang' => [ 'required', new LanguageParameter ],
            'per_page' => [ 'nullable', 'integer', 'min:1' ],
            'page' => [ 'nullable', 'integer', 'min:1' ],
            'category' => [ new CategoryParameter ],
            'tags' => [ new TagsParameter ],
            'with' => [ 'nullable', 'in:ingredients,category,tags' ],
            'with.*' => [ 'in:ingredients,category,tags' ],
            'diff_time' => [ 'nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        // Customize validation messages
        return [
            'lang.required' => 'The langauge parameter is required.',
            'per_page.integer' => 'The per_page value must be an integer.',
            'per_page.min' => 'The per_page value must be at least 1.',
            'page.integer' => 'The page value must be an integer.',
            'page.min' => 'The page value must be at least 1.',
            'with.in' => 'The entered :attribute attribute is invalid. Valid values are: ingredients,category and tags.',
            'with.*.in' => 'The entered :attribute attribute is invalid. Valid values are: ingredients,category and tags.',
            'diff_time.integer' => 'The entered :attribute attribute value must be an integer.',
            'diff_time.min' => 'The entered :attribute attribute value must be at least 1.'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new ValidationException($validator, response()->json([
            'errors' => $validator->errors()
        ],422));

        throw new HttpResponseException(
            response()->json(
                [
                    'errors' => $validator->errors()->first(),
                    'status_code' => 422,
                ],
                422,
            ),
        );
    }
}
