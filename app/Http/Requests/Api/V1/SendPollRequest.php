<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendPollRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string'],
            'question' => ['required', 'string'],
            'options' => ['required', 'array', 'min:2'],
            'options.*' => ['string'],
            'max_answer' => ['required', 'integer', 'min:1'],
            'duration' => ['nullable', 'integer', 'in:0,86400,604800,7776000'],
        ];
    }
}
