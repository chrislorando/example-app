<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public $authorization = [
        'index'=>'dashboard.index',
        'chart'=>'dashboard.chart',
    ];

    #[Layout('components.layouts.app')]
    public function render()
    {
        $this->authorize($this->authorization['index']);

        return view('livewire.dashboard')->title(__('label.dashboard'));
    }
}
