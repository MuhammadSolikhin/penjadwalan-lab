<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class KategoriBarangFormUpdate extends Component
{
    public $kategoriBarang;
    public $nama, $deskripsi;

    public function mount($hash)
    {
        $id = decrypt($hash);
        $this->kategoriBarang = KategoriBarang::findOrFail($id);
        $this->nama = $this->kategoriBarang->nama;
        $this->deskripsi = $this->kategoriBarang->deskripsi;
    }

    public function validateForm()
    {
        $rules = [
            'nama' => 'required|string|max:255|unique:kategori_barangs,nama,' . $this->kategoriBarang->id,
            'deskripsi' => 'required|string|max:1000',
        ];

        $messages = [
            'nama.required' => 'Nama kategori barang harus diisi.',
            'nama.unique' => 'Nama kategori barang sudah ada.',
            'deskripsi.required' => 'Deskripsi kategori barang harus diisi.',
        ];

        $this->validate($rules, $messages);
    }

    public function update()
    {
        $this->validateForm();

        try {
            DB::beginTransaction();

            $this->kategoriBarang->update([
                'nama' => $this->nama,
                'deskripsi' => $this->deskripsi,
            ]);

            DB::commit();
            session()->flash('success', 'Kategori barang berhasil diupdate.');
            return redirect()->route('kategori-barang.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat mengupdate kategori barang');
        }
    }

    public function render()
    {
        return view('livewire.kategori-barang.kategori-barang-form-update');
    }
}
