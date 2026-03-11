<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'age'              => 'required|integer|min:18|max:100',
            'family_history'   => 'required|in:none,distant,mother_sister,multiple',
            'age_first_period' => 'required|integer|min:8|max:20',
            'age_first_birth'  => 'required|in:before_20,20_to_29,after_30,no_children',
            'previous_biopsy'  => 'required|in:yes,no',
            'lump_detected'    => 'required|in:yes,no',
            'skin_changes'     => 'required|in:yes,no',
            'nipple_discharge' => 'required|in:yes,no',
            'breast_pain'      => 'required|in:yes,no',
        ];
    }

    public function message(): array
    {
        return[
            'age.min' => 'The age must be at least 18.',
            'age.max' => 'The age must not exceed 100.',
            'family_history.in' => 'The family history value is invalid.',
            'age_first_period.min' => 'The age of first period must be at least 8.',
            'age_first_period.max' => 'The age of first period must not exceed 20.',
            'age_first_birth.in' => 'The age of first birth value is invalid.',
            'previous_biopsy.in' => 'The previous biopsy value is invalid.',
            'lump_detected.in' => 'The lump detected value is invalid.',
            'skin_changes.in' => 'The skin changes value is invalid.',
            'nipple_discharge.in' => 'The nipple discharge value is invalid.',
            'breast_pain.in' => 'The breast pain value is invalid.',
        ];

    }
}
