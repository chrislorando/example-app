<?php

namespace App\Livewire\System;

use Livewire\Component;

class Profile extends Component
{
    public $layout = "components.layouts.app";
    public $view = "livewire.system.profile";
    public $pageTitle = "label.profile";

    public $authorization = [
        'index'=>'system.system.index',
        'update'=>'system.system.update',
        'updatePassword'=>'system.system.updatePassword',
        'deletePhoto'=>'system.country.deletePhoto',
    ];
    public function render()
    {
        return view($this->view)
        ->title(__($this->pageTitle))
        ->layout($this->layout);
    }
}
