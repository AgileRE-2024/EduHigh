<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLogbookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role == 'mahasiswa';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            "dosen_id" => ["required", "exists:dosens,id"],
            "date" => ["required", "date"],
            "notes" => ["required", "string"],
            "percentage" => ["nullable",  "integer", "min:0", "max:100"],
        ];
    }
}
