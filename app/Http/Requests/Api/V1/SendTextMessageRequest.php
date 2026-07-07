<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendTextMessageRequest extends FormRequest
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
            'message' => ['required', 'string'],
            'reply_message_id' => ['nullable', 'string'],
            'is_forwarded' => ['nullable', 'boolean'],
            'duration' => ['nullable', 'integer', 'in:0,86400,604800,7776000'],
            'mentions' => ['nullable', 'array'],
            'mentions.*' => ['string'],
        ];
    }
}
