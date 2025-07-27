<?php

namespace App\Livewire\KategoriBarang;

use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class KategoriBarang extends Component
{
    public $selectedHash;


    #[On('open-edit-modal')]
    public function openEditModal($hash)
    {
        $this->selectedHash = $hash;
    }

    public function render()
    {
        return view('livewire.kategori-barang.kategori-barang', ['path' => Route::currentRouteName()]);
    }
}
