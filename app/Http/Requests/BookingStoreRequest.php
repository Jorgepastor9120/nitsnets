<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'member_id' => ['required', 'int'],
            'court_id' => ['required', 'int'],
            'date' => ['required', 'date'],
            'hour_reserve_id' => ['required', 'int'],
        ];
    }

    public function messages()
    {
        return [
            'member_id.required' => 'El miembro es obligatorio.',
            'court_id.required' => 'la pista es obligatoria.',
            'date.required' => 'La fecha es obligatoria.',
            'hour_reserve_id.required' => 'La hora es obligatoria.',
        ];
    }
}
