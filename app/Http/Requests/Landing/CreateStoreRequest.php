<?php

namespace App\Http\Requests\Landing;

use Illuminate\Foundation\Http\FormRequest;

class CreateStoreRequest extends FormRequest
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
            'coords.lat' => [
                'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/ ',
                'required'
            ],
            'coords.lng' => [
                'regex:/^[-]?(([0-1]?[0-7]?[0-9])\.(\d+))|(180(\.0+)?)$/ ',
                'required'
            ],
            'location' => [
                'string',
                'required'
            ],
            'name' => [
                'string',
                'required'
            ],
            'open_from.id' => [
                'integer',
                'required'
            ],
            'open_from.time' => [
                'string',
                'required'
            ],
            'open_to.id' => [
                'integer',
                'required'
            ],
            'open_to.time' => [
                'string',
                'required'
            ],
            'tips' => [
                'string',
                'required'
            ],
            'working_days' => [
                'array',
                'required'
            ],
        ];
    }
}
