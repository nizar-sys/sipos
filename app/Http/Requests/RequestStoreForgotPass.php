<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreForgotPass extends FormRequest
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
            'email' => 'required|email|exists:tb_users,email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Kolom harus diisi!',
            'email.email' => 'Format email salah',
            'email.exists' => 'Email tidak ditemukan'
        ];
    }
}
