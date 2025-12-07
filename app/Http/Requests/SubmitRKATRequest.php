<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitRKATRequest extends FormRequest
{

    public function messages()
    {
        return [
            'tahun_anggaran.unique' => 'RKAT dengan Tahun Anggaran Tersebut Telah di buat ',
            'tahun_anggaran.required' => 'Tahun Anggaran Harus Di Isi ',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tahun_anggaran' => 'required|unique:rkats|max:4',
            'mode' => 'required',
        ];
    }
}
