<?php

namespace App\Livewire\KategoriBarang;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class KategoriBarangFormStore extends Component
{
    public function render()
    {
        return view('livewire.kategori-barang.kategori-barang-form-store');
    }
}
