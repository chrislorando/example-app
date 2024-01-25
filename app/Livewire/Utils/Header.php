<?php

namespace App\Livewire\Utils;

use Livewire\Component;
use App\Models\Menu AS MenuModel;
use App\Models\Country AS CountryModel;

class Header extends Component
{
    public function signout()
    {
        \Auth::logout();

        return $this->redirect('/login');

    }
    public function render()
    {
        $models = MenuModel::where('parent_id', null)->where('position', '0')->get();
        $languages = CountryModel::get();
        
        return view('livewire.utils.header', [
            'models' => $models,
            'languages' => $languages,
        ]);
    }
}
