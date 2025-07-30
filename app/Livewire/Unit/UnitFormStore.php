<?php

namespace App\Livewire\Unit;

use App\Models\Unit;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class UnitFormStore extends Component
{

    public $nama_unit, $jenis_unit;

    public function validateForm()
    {
        $rules = [
            'nama_unit' => 'required|string|max:255|unique:units,nama_unit',
            'jenis_unit' => 'required|string|in:genaral,lembaga,prodi',
        ];

        $messages = [
            'nama_unit.required' => 'Nama unit harus diisi.',
            'nama_unit.string' => 'Nama unit harus berupa teks.',
            'nama_unit.max' => 'Nama unit tidak boleh lebih dari 255 karakter.',
            'nama_unit.unique' => 'Nama unit sudah ada.',
            'jenis_unit.required' => 'Jenis unit harus dipilih.',
            'jenis_unit.in' => 'Jenis unit harus salah satu dari:general,lembaga,prodi.',
        ];

        $this->validate($rules, $messages);
    }

    public function store()
    {
        $this->validateForm();

        try {
            DB::beginTransaction();

            // generate kode_unit 6 digit acak
            $kode_unit = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);

            Unit::create([
                'kode_unit' => $kode_unit,
                'nama_unit' => $this->nama_unit,
                'jenis_unit' => $this->jenis_unit,
            ]);

            DB::commit();
            session()->flash('success', 'Unit berhasil ditambahkan.');
            return redirect()->route('unit.index');
        } catch (Exception $e) {
            DB::rollBack();
            // session()->flash('error', 'Terjadi kesalahan saat menambahkan unit: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menambahkan unit.');
        }
    }

    public function resetForm()
    {
        $this->nama_unit = '';
        $this->jenis_unit = '';
    }

    public function render()
    {
        return view('livewire.unit.unit-form-store');
    }
}
