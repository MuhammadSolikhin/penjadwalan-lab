<?php

namespace App\Livewire\Unit;

use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class Unit extends Component
{
    public $selectedHash;


    #[On('open-edit-modal')]
    public function openEditModal($hash)
    {
        $this->selectedHash = $hash;
    }

    public function render()
    {
        return view('livewire.unit.unit', ['path' => Route::currentRouteName() ]);
    }
}
