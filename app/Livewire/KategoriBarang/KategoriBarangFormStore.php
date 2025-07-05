<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class KategoriBarangFormStore extends Component
{

    public $nama, $deskripsi;

    public function validateForm()
    {
        $rules = [
            'nama' => 'required|string|max:255|unique:kategori_barangs,nama',
            'deskripsi' => 'required|string|max:1000',
        ];

        $messages = [
            'nama.required' => 'Nama kategori barang harus diisi.',
            'nama.unique' => 'Nama kategori barang sudah ada.',
            'deskripsi.required' => 'Deskripsi kategori barang harus diisi.',
        ];

        $this->validate($rules, $messages);
    }


    public function store()
    {
        $this->validateForm();

        KategoriBarang::create([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        return redirect()->route('kategori-barang.index'); // Pastikan route ini ada
    }

    public function render()
    {
        return view('livewire.kategori-barang.kategori-barang-form-store');
    }
}
