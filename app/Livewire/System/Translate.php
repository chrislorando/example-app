<?php

namespace App\Livewire\System;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Models\Translate AS TranslateModel;
use Illuminate\Validation\Rule;

class Translate extends Component
{
  use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;

    public $layout = "components.layouts.app";

    public $view = "livewire.system.translate";
    public $pageTitle = "label.translate";

    // #[Url(keep: true)] 
    public $q = "";
    public $is_deleted_q;
    public $sortField = "id";
    public $sortDirection = "asc";
    public $perPage = 10;

    public $queryString = ['q', 'is_deleted_q', 'sortField', 'sortDirection'];

    public $authorization = [
        'index'=>'system.translate.index',
        'create'=>'system.translate.create',
        'store'=>'system.translate.store',
        'edit'=>'system.translate.edit',
        'update'=>'system.translate.update',
        'delete'=>'system.translate.delete',
        'restore'=>'system.translate.restore'
    ];


    public $isFormOpen = false;

    public $isViewOpen = false;

    public $isNewRecord = true;

    public $id, $uuid;

    public $locale;

    public $group;

    public $code;

    public $value;

    public $is_deleted;

    protected array $rules = [];
    protected function rules() 
    {
        return [
            'code' => [
                'required',
                'min:2',
                Rule::unique('translates')->ignore($this->id)
            ],
            'value' => 'required',
            'locale' => 'required',
            'group' => 'required',
        ];
    }

    public function mount()
    {
        $this->rules = $this->rules();
    }

    public function sort($field){
        $this->sortDirection = $this->sortField === $field ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc' : 'asc';
        $this->sortField = $field;
    }

    public function index($reload=false)
    {
        $this->isFormOpen = false;
        $this->isViewOpen = false;

        $this->dispatch('close-modal'); 

        if($reload){
            return $this->redirect('/system/translate', navigate: true);
        }
    }

    public function create()
    {
        $this->authorize($this->authorization['create']);
        $this->reset();

        $this->isFormOpen = true;
        $this->dispatch('open-modal'); 

        $this->isNewRecord = true;
    }

    public function store()
    {
        $this->authorize($this->authorization['store']);

        $this->validate();

        $data = [
            'uuid'=> Str::uuid(),
            'locale'=> $this->locale,
            'group'=> $this->group,
            'code'=> $this->code,
            'value'=> $this->value,
        ];

     
        $model = TranslateModel::create($data);

        if($model){
            session()->flash('message', "Data successfully created.");
            $this->q = $this->code;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');         
        }else{
            session()->flash('error', 'Data cannot be created.');
        }

 
    }

    public function edit($id)
    {
        $this->authorize($this->authorization['edit']);

        $this->reset();
        $this->isFormOpen = true;
        $this->dispatch('open-modal'); 

        $this->isNewRecord = false;

        $model = TranslateModel::withTrashed()->find($id);
        
        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->locale = $model->locale;
        $this->group = $model->group;
        $this->code = $model->code;
        $this->value = $model->value;
        $this->is_deleted = $model->is_deleted;
    }

    public function update()
    {
        $this->authorize($this->authorization['update']);

        $this->validate();

        $data = [
            'locale'=> $this->locale,
            'group'=> $this->group,
            'code'=> $this->code,
            'value'=> $this->value, 
        ];

        $model = TranslateModel::withTrashed()->find($this->id)->update($data);

        if($model){
            session()->flash('message', "Data successfully updated.");
            // $this->reset();
            $this->q = $this->code;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');        
        }else{
            session()->flash('error', 'Data cannot be updated.');
        }
    }

    public function restore($id)
    {
        $this->authorize($this->authorization['restore']);

        $model = TranslateModel::withTrashed()->find($id);

        $model->is_deleted = '0';
        $model->save();
        $model->restore();
    }

    public function delete($id)
    {
        $this->authorize($this->authorization['delete']);

        $model = TranslateModel::withTrashed()->find($id);

        if($model->trashed()){
            $model->forceDelete();
        }else{
            $model->is_deleted = '1';
            $model->save();
            $model->delete();
        }
        
    }
    
    public function consume(){
        $strarray = include(base_path() . '/lang/en/validation.php');
        $array = [];
        foreach($strarray as $key=>$row){
            $array[] = [
                'uuid'=> Str::uuid(),
                'locale'=>'en',
                'group'=>'label',
                'code'=>$key,
                'value'=>$row,
            ];
        }
        TranslateModel::insert($array);
        // dd($array);
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize($this->authorization['index']);

        $countries = TranslateModel::withTrashed()->select("*")->when($this->is_deleted_q!="", function ($query)  {
            $query->where('is_deleted',$this->is_deleted_q);
        });

        $models = $countries->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        return view($this->view, [
            'models' => $models,
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
    }
}
