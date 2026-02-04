<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslatorShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to view translator profiles
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:translator_portfolios,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.required' => 'Tarjimon ID talab qilinadi.',
            'id.integer' => 'Tarjimon ID raqam bo\'lishi kerak.',
            'id.exists' => 'Bunday tarjimon mavjud emas.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
