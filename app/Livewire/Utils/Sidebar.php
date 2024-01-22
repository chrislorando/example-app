<?php

namespace App\Livewire\Utils;

use Livewire\Component;
use App\Models\Menu AS MenuModel;
class Sidebar extends Component
{
    public $toggle;

    public $url;

    public function mount(){
        $this->url = request()->route()->uri;
    }
    public function render()
    {
        $model = MenuModel::where("url", $this->url)->where('parent_id', null)->first();

        $models = [];
        if($model){
            session()->put('topparent', $model->id);
        }

        $models = MenuModel::where('parent_id', session()->get('topparent'))->where('position', '1')->get();

        return view('livewire.utils.sidebar', [
            'models' => $models,
        ]);
    }
}
