<?php

namespace App\Http\Requests;

use App\Priority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TaskListRequest extends FormRequest
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
            'priority' => [new Enum(Priority::class)],
            'daysFrom' => ['integer', 'gte:1'],
            'daysTo' => ['integer', 'gte:1'],
            'sortBy' => Rule::in(['priority', 'expiration']),
            'sortOrder' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages()
    {
        return [
            'sortBy' => "The selected 'sortBy' parameter accepts only 'priority' or 'expiration' value.",
            'sortOrder' => "The selected 'sortOrder' parameter accepts only 'asc' or 'desc' value.",
        ];
    }
}
