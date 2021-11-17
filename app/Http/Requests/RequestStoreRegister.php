<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreRegister extends FormRequest
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
            'username' => 'required|unique:tb_users,username|',
            'email' => 'required|email|unique:tb_users,email|email',
            'password' => 'required|min:6',
            'password2' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Kolom wajib diisi!',
            '*.unique' => 'Data sudah terdaftar',
            'password.min' => 'Katasandi harus lebih dari 6 karakter',
            'password2.same' => 'Konfirmasi katasandi tidak sesuai'
        ];
    }
}
