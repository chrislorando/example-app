<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class Breadcrumb extends Component
{
    public $breadCrumbs;
    public function mount()
    {
        $route = explode("/",request()->path());
        $this->breadCrumbs = array_filter($route);
    }

    public function render()
    {
        return view('livewire.utils.breadcrumb');
    }
}
