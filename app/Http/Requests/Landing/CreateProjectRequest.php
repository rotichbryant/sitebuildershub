<?php

namespace App\Http\Requests\Landing;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'content' => [
                'string',
                'required'
            ],
            'end_date' => [
                'string',
                'required'
            ],
            'files' => [
                'array',
                'required'
            ],            
            'start_date' => [
                'string',
                'required'
            ],
            'title' => [
                'string',
                'required'
            ],
        ];
    }
}
