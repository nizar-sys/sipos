<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestPostPayment extends FormRequest
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
            'trx_code' => 'required|exists:tb_transactions,detail_transaksi',
            'bukti_tf' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20348'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Bukti Transfer / Code Transaksi Wajib Diisi.',
            'trx_code.exists' => 'Kode Transaksi Tidak Sah!',
        ];   
    }
}
