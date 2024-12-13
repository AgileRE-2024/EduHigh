<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role == 'dosen';
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
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'schedule_id' => 'required|exists:schedules,id',
            'status' => 'required|in:approved,rejected',
            'reason' => 'required_if:status,rejected',
        ];
    }
}
