<?php

namespace App\Livewire\Unit;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Unit extends Component
{
    public function render()
    {
        return view('livewire.unit.unit');
    }
}
