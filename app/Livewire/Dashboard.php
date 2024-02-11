<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Expense;

class Dashboard extends Component
{
    public $layout = "components.layouts.app";
    public $view = "livewire.dashboard";
    public $pageTitle = "label.dashboard";

    // public $show = false;

    public $authorization = [
        'index'=>'dashboard.index',
        'chart'=>'dashboard.chart',
    ];

   
    public function show(){
        // dd('');
        $this->dispatch('chart'); 
    }



    public function render()
    {
        $this->authorize($this->authorization['index']);


        $data = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'Bar Dataset',
                    'backgroundColor' => '#f87979',
                    'data' => [12, 19, 3, 5, 2, 3, 11],
                    'order'=> 2
                ],
                [
                    'label' => 'Line Dataset',
                    'backgroundColor' => '#00D8FA',
                    'borderColor'=> 'rgb(75, 192, 192)',
                    'data' => [15, 20, 23, 25, 22, 23, 21],
                    'type'=>'line',
                    'order'=> 0
                ]
            ]
        ];


        return view($this->view, [
            'data'=>$data,
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
    }
}
