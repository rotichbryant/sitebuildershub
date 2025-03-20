<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class SystemRequest extends FormRequest
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
            'tab' => [
                'required',
                'string',
                'in:images,mail,payment'
            ],
            'logo' => [
                'sometimes',
                'required_if:tab,images',
                File::image()->types('jpeg,png,jpg')->max(2048)
            ],
            'icon' => [
                'sometimes',
                'required_if:tab,images',
                File::image()->types('jpeg,png,jpg')->max(2048)
            ],
            'host' => [
                'required_if:tab,mail',
                'string'
            ],
            'password' => [
                'required_if:tab,mail',
                'string'
            ],
            'port' => [
                'required_if:tab,mail',
                'string'
            ],
            'username' => [
                'required_if:tab,mail',
                'string'
            ]
        ];
    }
}
