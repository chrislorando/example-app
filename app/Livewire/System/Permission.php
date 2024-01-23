<?php

namespace App\Livewire\System;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Component;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Models\Permission AS PermissionModel;
use Illuminate\Validation\Rule;

class Permission extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $layout = "components.layouts.app";

    public $view = "livewire.system.permission";
    public $pageTitle = "label.permission";

    // #[Url(keep: true)] 
    public $q = "";

    public $sortField = "id";
    public $sortDirection = "asc";
    public $perPage = 10;

    public $queryString = ['q', 'sortField', 'sortDirection'];

    public $authorization = [
        'index'=>'system.permission.index',
        'create'=>'system.permission.create',
        'store'=>'system.permission.store',
        'edit'=>'system.permission.edit',
        'update'=>'system.permission.update',
        'delete'=>'system.permission.delete',
        'generate'=>'system.permission.generate',
    ];


    public $isFormOpen = false;

    public $isNewRecord = true;

    public $id, $uuid;

    public $name;

    public $guard_name;

    public $controller;

    public $action;

    public $method;

    public $params;

    public $alias;

    public $description;

    protected array $rules = [];
    protected function rules() 
    {
        return [
            'name' => [
                'required',
                Rule::unique('permissions')->ignore($this->id)
            ],
            'guard_name' => [
                'required',
            ],
            'controller' => [
                'required',
            ],
            'action' => [
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
            'guard_name'=> $this->guard_name,
            'name'=> $this->name,
            'controller'=> $this->controller,
            'action'=> $this->action,
            'method'=> $this->method,
            'params'=> $this->params,
            'alias'=> $this->alias,
            'description'=> $this->description,
        ];

 
        $model = PermissionModel::create($data);

        if($model){
            session()->flash('message', __('message.success_create'));

            $this->q = $this->name;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');         
        }else{
            session()->flash('error', __('message.error_create'));
        }

 
    }

    public function edit(PermissionModel $model)
    {
        $this->authorize($this->authorization['edit']);

        $this->reset();

        $this->isFormOpen = true;
        $this->dispatch('open-modal'); 

        $this->isNewRecord = false;
        
        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->guard_name = $model->guard_name;
        $this->name = $model->name;
        $this->controller = $model->controller;
        $this->action = $model->action;
        $this->method = $model->method;
        $this->params = $model->params;
        $this->alias = $model->alias;
        $this->description = $model->description;
    }

    public function update()
    {
        $this->authorize($this->authorization['update']);


        $this->validate();

        $data = [
            'guard_name'=> $this->guard_name,
            'name'=> $this->name,
            'controller'=> $this->controller,
            'action'=> $this->action,
            'method'=> $this->method,
            'params'=> $this->params,
            'alias'=> $this->alias,
            'description'=> $this->description,
        ];


        $model = PermissionModel::where('uuid', $this->uuid)->update($data);

        if($model){
            session()->flash('message', __('message.success_update'));
            $this->q = $this->name;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');        
        }else{
            session()->flash('error', __('message.error_update'));
        }
    }

    public function delete(PermissionModel $model)
    {
        $this->authorize($this->authorization['delete']);

        $model->delete();

        session()->flash('message', __('message.success_delete'));
    }
   
    public function search()
    {
        $this->resetPage();
    }

    public function generate()
    {
        $this->authorize($this->authorization['generate']);

        $directory = "/Livewire";
      
        foreach (glob(app_path().$directory.'/*') as $key=>$controller) {
          
            $controllername = basename($controller, '.php');
            $folder = basename(dirname($controller));
            $class = 'App\Livewire\\'.$controllername;
         

            if (class_exists($class)) {
                $ref = new $class;
                if(isset($ref->authorization)){
                    foreach($ref->authorization as $row){
                        $explode = explode('.',$row);
                        $action = end($explode);
                        $alias = null;
                        if($action=='index'){
                            $alias = strtolower($controllername);
                        }
                        $existsC = PermissionModel::where('name',$row)->first();
                        if(!$existsC){
                            PermissionModel::create([
                                'uuid'=> Str::uuid(),
                                'guard_name'=> 'web',
                                'name'=> $row,
                                'controller'=> $class,
                                'action'=> $action,
                                'method'=> null,
                                'params'=> null,
                                'alias'=> $alias,
                                'description'=> null,
                            ]);
                        }
                    }
                }
            }else{
                foreach (glob($controller.'/*') as $k=>$con) {
                    $controllername = basename($con, '.php');
                    $folder = basename(dirname($con));
                    $class = 'App\Livewire\\'.$folder.'\\'.$controllername;
                    $ref = new $class;
                    if(isset($ref->authorization)){
                        foreach($ref->authorization as $row){
                            $explode = explode('.',$row);
                            $action = end($explode);
                            $alias = null;
                            if($action=='index'){
                                $alias = strtolower($folder.'/'.$controllername);
                            }
                            $existsC = PermissionModel::where('name',$row)->first();
                            if(!$existsC){
                                PermissionModel::create([
                                    'uuid'=> Str::uuid(),
                                    'guard_name'=> 'web',
                                    'name'=> $row,
                                    'controller'=> $class,
                                    'action'=> $action,
                                    'method'=> null,
                                    'params'=> null,
                                    'alias'=> $alias,
                                    'description'=> null,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        session()->flash('message', __('message.success_create'));
    
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $this->authorize($this->authorization['index']);

        $model = PermissionModel::select("*");

        $model->where(function ($query) {
            $query->where('name','like', '%' . $this->q . '%')
            ->orWhere('guard_name','like', '%' . $this->q . '%')
            ->orWhere('controller','like', '%' . $this->q . '%');
        });

        $permissions = $model->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        return view($this->view, [
            'models' => $permissions,
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
        
    }
}
