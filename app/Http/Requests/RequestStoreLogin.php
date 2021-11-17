<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreLogin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|exists:tb_users,username',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Kolom harus diisi!',
            'username.exists' => 'Username belum terdaftar'
        ];
    }
}
