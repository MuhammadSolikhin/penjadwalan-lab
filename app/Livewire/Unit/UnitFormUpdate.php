<?php

namespace App\Livewire\Unit;

use App\Models\Unit;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class UnitFormUpdate extends Component
{
    public $unit_id, $nama_unit, $jenis_unit;

    public function mount($hash)
    {
        $id = decrypt($hash);
        $unit = Unit::findOrFail($id);

        $this->unit_id = $unit->id;
        $this->nama_unit = $unit->nama_unit;
        $this->jenis_unit = $unit->jenis_unit;
    }

    public function validateForm()
    {
        $rules = [
            'nama_unit' => 'required|string|max:255|unique:units,nama_unit,' . $this->unit_id,
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

    public function update()
    {
        $this->validateForm();

        try {
            DB::beginTransaction();

            $unit = Unit::findOrFail($this->unit_id);
            $unit->update([
                'nama_unit' => $this->nama_unit,
                'jenis_unit' => $this->jenis_unit,
            ]);

            DB::commit();
            session()->flash('success', 'Unit berhasil diubah.');
            return redirect()->route('unit.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat mengubah unit.');
        }
    }

    public function resetForm()
    {
        $unit = Unit::findOrFail($this->unit_id);
        $this->nama_unit = $unit->nama_unit;
        $this->jenis_unit = $unit->jenis_unit;
    }

    public function render()
    {
        return view('livewire.unit.unit-form-update');
    }
}
