<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEmailAccountRequest extends FormRequest
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
            'incoming_encryption' => 'required|string|in:ssl,tls',
            'incoming_port'       => 'required|numeric|in:143,993',
            'incoming_server'     => 'required|string',
            'outgoing_encryption' => 'required|string|in:ssl,tls',
            'outgoing_port'       => 'required|numeric|in:465,587',
            'outgoing_server'     => 'required|string',
            'password'            => 'required|string',
            'username'            => 'required|string',
        ];
    }
}
