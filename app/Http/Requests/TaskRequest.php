<?php

namespace App\Http\Requests;

use App\Priority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'description' => ['nullable', 'string', 'min:3'],
            'priority' => ['required', new Enum(Priority::class)],
            'control_at' => ['nullable', 'date', 'after:today'],
            'is_completed' => ['boolean']
        ];
    }
}
