<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class Autocomplete extends Component
{
    public $data;

    public function mount($data = null)
    {
        $this->data = $data;
    }
    
    // public function render()
    // {
    //     return view('livewire.utils.autocomplete');
    // }
}
