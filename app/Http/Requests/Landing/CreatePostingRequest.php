<?php

namespace App\Http\Requests\Landing;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostingRequest extends FormRequest
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
            //
            'category' => [
                'string',
                'required'
            ],
            'description' => [
                'string',
                'required'
            ],
            'images' => [
                'array',
                'required'
            ],
            'location' => [
                'string',
                'required'
            ],
            'negotiate' => [
                'string',
                'required'
            ],
            'phone_number' => [
                'string',
                'required'
            ],
            'price' => [
                'integer',
                'required'
            ],
            'quantity' => [
                'integer',
                'required'
            ],
            'title' => [
                'string',
                'required'
            ],
        ];
    }
}
