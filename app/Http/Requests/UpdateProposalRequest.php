<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'topic' => 'required|string|max:255',
            'subkbk_id' => 'required|exists:subkbks,id',
            'titles.*' => 'required|string|max:255',
            'background' => 'required|string|max:1000',
            'backgroundReasons.*' => 'nullable|string|max:255',
            'previousResearch.*.title' => 'nullable|string|max:255',
            'previousResearch.*.doi' => 'nullable|string|max:255',
            'previousResearch.*.authors' => 'nullable|string|max:255',
            'previousResearch.*.problem' => 'nullable|string|max:255',
            'previousResearch.*.results' => 'nullable|string|max:255',
            'researchQuestions.*' => 'nullable|string|max:255',
            'researchOutputs.*' => 'nullable|string|max:255',
            'methodology' => 'nullable|string|max:1000',
        ];
    }
}
