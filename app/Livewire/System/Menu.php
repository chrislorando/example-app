<?php

namespace App\Livewire\System;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Menu AS MenuModel;
use App\Models\Permission AS PermissionModel;
use Illuminate\Validation\Rule;

class Menu extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    
    public $layout = "components.layouts.app";

    public $view = "livewire.system.menu";

    public $pageTitle = "label.menu";

    public $q = "";
    public $is_deleted_q;
    public $permission_q = "";
    public $sortField = "id";
    public $sortDirection = "asc";
    public $perPage = 10;

    public $queryString = ['q', 'is_deleted_q', 'sortField', 'sortDirection'];

    public $authorization = [
        'index'=>'system.menu.index',
        'create'=>'system.menu.create',
        'store'=>'system.menu.store',
        'edit'=>'system.menu.edit',
        'update'=>'system.menu.update',
        'delete'=>'system.menu.delete',
        'show'=>'system.menu.show',
        'restore'=>'system.menu.restore',
    ];

    public $isFormOpen = false;

    public $isNewRecord = true;

    public $id, $parent_id, $uuid;

    public $sequence;

    public $icon;

    public $code;

    public $name;

    public $translate;

    public $url;

    public $url_q;

    public $description;

    public $position;

    public $is_deleted;


    protected array $rules = [];
    protected function rules() 
    {
        return [
            'sequence' => [
                'required',
            ],
            'name' => [
                'required',
                Rule::unique('menus')->ignore($this->id)
            ],
            'url' => [
                'required',
            ],
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
            return $this->redirect('/system/user', navigate: true);
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
            'sequence'=> $this->sequence,
            'icon'=> $this->icon,
            'parent_id'=> $this->parent_id,
            'code'=> $this->code,
            'name'=> $this->name,
            'translate'=> $this->translate,
            'url'=> $this->url,
            'description'=> $this->description,
            'position'=> $this->position,
        ];

        if($this->is_deleted){
            $data['is_deleted'] = '1';
        }else{
            $data['is_deleted'] = '0';
        }

 
        $model = MenuModel::create($data);

        if($model){
            session()->flash('message', __('message.success_create'));
            $this->q = $this->name;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');         
        }else{
            session()->flash('error', __('message.error_create'));
        }

 
    }

    public function edit($id)
    {
        $this->authorize($this->authorization['edit']);

        $this->reset();

        $this->isFormOpen = true;
        $this->dispatch('open-modal'); 

        $this->isNewRecord = false;

        $model = MenuModel::withTrashed()->find($id);
        
        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->sequence = $model->sequence;
        $this->icon = $model->icon;
        $this->parent_id = $model->parent_id;
        $this->code = $model->code;
        $this->name = $model->name;
        $this->translate = $model->translate;
        $this->url = $model->url;
        $this->description = $model->description;
        $this->position = $model->position;
        $this->is_deleted = $model->is_deleted;
    }

    public function update()
    {
        $this->authorize($this->authorization['update']);


        $this->validate();
        
        $data = [
            'sequence'=> $this->sequence,
            'icon'=> $this->icon,
            'parent_id'=> $this->parent_id,
            'code'=> $this->code,
            'name'=> $this->name,
            'translate'=> $this->translate,
            'url'=> $this->url,
            'description'=> $this->description,
            'position'=> $this->position,
        ];

        if($this->is_deleted){
            $data['is_deleted'] = '1';
        }else{
            $data['is_deleted'] = '0';
        }

        $model = MenuModel::withTrashed()->find($this->id)->update($data);

        if($model){
            session()->flash('message', __('message.success_update'));
            $this->q = $this->name;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');        
        }else{
            session()->flash('error', __('message.error_update'));
        }
    }

    public function restore($id)
    {
        $this->authorize($this->authorization['restore']);

        $model = MenuModel::withTrashed()->find($id);

        $model->is_deleted = '0';
        $model->save();
        $model->restore();

        session()->flash('message', __('message.success_restore'));
    }

    public function delete($id)
    {
        $this->authorize($this->authorization['delete']);

        $model = MenuModel::withTrashed()->find($id);

        if($model->trashed()){
            $model->forceDelete();
        }else{
            $model->is_deleted = '1';
            $model->save();
            $model->delete();
        }

        session()->flash('message', __('message.success_delete'));
        
    }
   
    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize($this->authorization['index']);

        $model = MenuModel::withTrashed()->select("*")->when($this->is_deleted_q!="", function ($query)  {
            $query->where('is_deleted',$this->is_deleted_q);
        });

        $model->where(function ($query) {
            $query->where('code','like', '%' . $this->q . '%')
            ->orWhere('name','like', '%' . $this->q . '%')
            ->orWhere('translate','like', '%' . $this->q . '%')
            ->orWhere('description','like', '%' . $this->q . '%');
        });

        $menus = $model->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        $optionsModel = MenuModel::get();
        $optionsMenu = [];
        foreach($optionsModel as $r){
            $optionsMenu[] = [
                'value'=> $r->id,
                'text'=> $r->name
            ];
        }

        $optionsPermission = [];
        if($this->url_q){
            $modelPermission = PermissionModel::select("*")->when($this->url_q!="", function ($query)  {
                $query->whereNotNull('alias');
                $query->where(function($query){
                    $query
                    ->orWhere('name','like', '%' . $this->url_q . '%')
                    ->orWhere('controller','like', '%' . $this->url_q . '%')
                    ->orWhere('action','like', '%' . $this->url_q . '%')
                    ->orWhere('alias','like', '%' . $this->url_q . '%');
                });
            })
            ->limit(10)
            ->get();

            foreach($modelPermission as $r){
                $optionsPermission[] = [
                    'value'=> $r->alias,
                    'text'=> $r->alias
                ];
            }
        }
       

        return view($this->view, [
            'models' => $menus,
            'optionsMenu'=>$optionsMenu,
            'optionsPermission'=>$optionsPermission
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
    }
}
