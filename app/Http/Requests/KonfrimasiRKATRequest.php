<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonfrimasiRKATRequest extends FormRequest
{

    public function messages()
    {
        return [
            'tahun_anggaran.unique' => 'RKAT dengan Tahun Anggaran Tersebut Telah di buat ',
            'tahun_anggaran.required' => 'Tahun Anggaran Harus Di Isi ',
        ];
    }
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rkat_id' => 'required',
            'keputusan' => 'required|min:0',
        ];
    }
}
