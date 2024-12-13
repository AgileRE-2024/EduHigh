<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProposalRequest extends FormRequest
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
            'background' => 'nullable|string|max:1000',
            'backgroundReasons.*' => 'nullable|string|max:255',
            'previousResearches.*.title' => 'nullable|string|max:255',
            'previousResearches.*.doi' => 'nullable|string|max:255',
            'previousResearches.*.authors' => 'nullable|string|max:255',
            'previousResearches.*.problem_statement' => 'nullable|string|max:255',
            'previousResearches.*.results' => 'nullable|string|max:255',
            'researchQuestions.*' => 'nullable|string|max:255',
            'outputs.*' => 'nullable|string|max:255',
            'methodology' => 'nullable|string|max:1000',
        ];
    }
}
