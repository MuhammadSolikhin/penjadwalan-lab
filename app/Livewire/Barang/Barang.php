<?php

namespace App\Livewire\Barang;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Barang extends Component
{
    public function render()
    {
        return view('livewire.barang.barang');
    }
}
