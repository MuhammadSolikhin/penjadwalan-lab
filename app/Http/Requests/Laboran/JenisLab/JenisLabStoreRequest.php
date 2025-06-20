<?php

namespace App\Http\Requests\Laboran\JenisLab;

use Illuminate\Foundation\Http\FormRequest;
<<<<<<< HEAD
=======
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599

class JenisLabStoreRequest extends FormRequest
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
<<<<<<< HEAD
            'name' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/|unique:jenislabs,name',
            'description' => 'nullable|string'
=======
            'nama_jenis_lab_store' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/|unique:jenislabs,nama_jenis_lab',
            'deskripsi_jenis_lab_store' => 'nullable|string'
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
        ];
    }

    public function messages(): array
    {
        return [
<<<<<<< HEAD
            'name.required' => 'Nama Jenis Lab Harus Terisi',
            'name.string' => 'Nama Jenis Lab harus berupa string',
            'name.max' => 'Nama Jenis Lab tidak boleh melebihi 100 Kata',
            'name.regex' => 'Nama Jenis Lab tidak boleh berupa simbol',
            'name.unique' => 'Nama Jenis Lab sudah terpakai',

            'description.string' => 'Deskripsi harus berupa string'
        ];
    }
=======
            'nama_jenis_lab_store.required' => 'Nama Jenis Lab Harus Terisi',
            'nama_jenis_lab_store.string' => 'Nama Jenis Lab harus berupa string',
            'nama_jenis_lab_store.max' => 'Nama Jenis Lab tidak boleh melebihi 100 Kata',
            'nama_jenis_lab_store.regex' => 'Nama Jenis Lab tidak boleh berupa simbol',
            'nama_jenis_lab_store.unique' => 'Nama Jenis Lab sudah terpakai',

            'deskripsi_jenis_lab_store.string' => 'Deskripsi harus berupa string'
        ];
    }

    // Kalau ada gagal input, supaya modal nya tetap tampil
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()
                ->route('laboran.laboratorium')
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'createJenisLab') // modal identifier
        );
    }

>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
}
