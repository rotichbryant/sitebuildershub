<?php

namespace App\Http\Requests\Landing;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalProfile extends FormRequest
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
            'first_name'  => 'required|string',
            'last_name'   => 'required|string',
            'location'    => 'nullable|string',
            'picture'     => 'nullable|string',
            'phone_number'=> 'required|string',
        ];
    }
}
