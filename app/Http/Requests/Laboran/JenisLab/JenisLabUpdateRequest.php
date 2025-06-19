<?php

namespace App\Http\Requests\Laboran\JenisLab;

<<<<<<< HEAD
use Illuminate\Foundation\Http\FormRequest;
=======
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599

class JenisLabUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/|unique:jenislabs,name,' . $this->jenislab->slug . ',slug',
            'description' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Jenis Lab Harus Terisi',
            'name.string' => 'Nama Jenis Lab harus berupa string',
            'name.max' => 'Nama Jenis Lab tidak boleh melebihi 100 Kata',
            'name.regex' => 'Nama Jenis Lab tidak boleh berupa simbol',
            'name.unique' => 'Nama Jenis Lab sudah terpakai',

            'description.string' => 'Deskripsi harus berupa string'
        ];
    }
=======
            'nama_jenis_lab_update' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/|unique:jenislabs,nama_jenis_lab,' . Crypt::decryptString($this->id_jenis_lab_update) . ',id',
            'deskripsi_jenis_lab_update' => 'nullable|string'
        ];
    }

    // $this->JenisLab->slug_jenis_lab_update

    public function messages(): array
    {
        return [
            'nama_jenis_lab_update.required' => 'Nama Jenis Lab Harus Terisi',
            'nama_jenis_lab_update.string' => 'Nama Jenis Lab harus berupa string',
            'nama_jenis_lab_update.max' => 'Nama Jenis Lab tidak boleh melebihi 100 Kata',
            'nama_jenis_lab_update.regex' => 'Nama Jenis Lab tidak boleh berupa simbol',
            'nama_jenis_lab_update.unique' => 'Nama Jenis Lab sudah terpakai',

            'deskripsi_jenis_lab_update.string' => 'Deskripsi harus berupa string'
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
                ->with('form', 'editJenisLab') // modal identifier
        );
    }
>>>>>>> 4107aac2a9b972583670c9a86514222ee0cb2599
}
