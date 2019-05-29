<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnalysisCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'analisys_text' => 'required|string|between:50,100000',
            'referral_law' => 'nullable|string',
            'law_link' => 'nullable|string',
            'percent_votes' => 'nullable|numeric',
            'vote_number' => 'required|numeric',
            'minimum_signatures' => 'nullable|numeric',
            'status' => 'required'
        ];
    }
}
