<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
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
            'active' => [
                'required',
                'boolean'
            ],
            'default' => [
                'required',
                'boolean'
            ],            
            'description' => [
                'required',
                'string'
            ],
            'features.max_posts' => [
                'required',
                'integer'
            ],
            'features.for_professionals' => [
                'sometimes',
                'nullable',
                'boolean'
            ],
            'features.for_businesses' => [
                'sometimes',
                'nullable',
                'boolean'
            ],                        
            'name' => [
                'string',
                'required'
            ],
            'price' => [
                'required',
                'numeric'
            ]
        ];
    }
}
