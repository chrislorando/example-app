<?php

namespace App\Livewire\System;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Role AS RoleModel;
use App\Models\Permission AS PermissionModel;
use App\Models\RolePermission AS RolePermissionModel;
use Illuminate\Validation\Rule;


class Role extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $layout = "components.layouts.app";

    public $view = "livewire.system.role";
    public $pageTitle = "label.role";

    // #[Url(keep: true)] 
    public $q = "";
    public $is_public_q;

    public $is_deleted_q;

    public $sortField = "id";
    public $sortDirection = "asc";
    public $perPage = 10;

    public $queryString = ['q', 'is_deleted_q', 'sortField', 'sortDirection'];

    public $authorization = [
        'index'=>'system.role.index',
        'create'=>'system.role.create',
        'store'=>'system.role.store',
        'edit'=>'system.role.edit',
        'update'=>'system.role.update',
        'delete'=>'system.role.delete',
        'restore'=>'system.role.restore',
        'show'=>'system.role.show',
        'permission'=>'system.role.permission',
        'copy'=>'system.role.copy',
    ];


    public $isFormOpen = false;

    public $isViewOpen = false;

    public $isNewRecord = true;

    public $id, $uuid;

    public $name;

    public $guard_name;

    public $redirect;

    public $is_public;

    public $description;

    public $rolePermissions;

    protected array $rules = [];
    protected function rules() 
    {
        return [
            'name' => [
                'required',
                Rule::unique('roles')->ignore($this->id)
            ],
            'guard_name' => [
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
            return $this->redirect('/system/role', navigate: true);
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
            'name'=> $this->name,
            'guard_name'=> $this->guard_name,
            'redirect'=> $this->redirect,
            'description'=> $this->description,
        ];

        if($this->is_public){
            $data['is_public'] = '1';
        }else{
            $data['is_public'] = '0';
        }
   
        $model = RoleModel::create($data);

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
        
        $model = RoleModel::withTrashed()->find($id);

        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->name = $model->name;
        $this->guard_name = $model->guard_name;
        $this->is_public = $model->is_public;
        $this->redirect = $model->redirect;
        $this->description = $model->description;
    }

    public function update()
    {
        $this->authorize($this->authorization['update']);


        $this->validate();

        $data = [
            'name'=> $this->name,   
            'guard_name'=> $this->guard_name,   
            'redirect'=> $this->redirect, 
            'description'=> $this->description,
        ];


        if($this->is_public){
            $data['is_public'] = '1';
        }else{
            $data['is_public'] = '0';
        }
   
        $model = RoleModel::withTrashed()->find($this->id)->update($data);

        if($model){
            session()->flash('message', __('message.success_update'));
            $this->q = $this->name;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');        
        }else{
            session()->flash('error', __('message.success_update'));
        }
    }

    public function restore($id)
    {
        $this->authorize($this->authorization['restore']);

        $model = RoleModel::withTrashed()->find($id);

        $model->is_deleted = '0';
        $model->save();
        $model->restore();

        session()->flash('message', __('message.success_restore'));
    }

    public function delete($id)
    {
        $this->authorize($this->authorization['delete']);

        $model = RoleModel::withTrashed()->find($id);

        if($model->trashed()){
            $model->forceDelete();
        }else{
            $model->is_deleted = '1';
            $model->save();
            $model->delete();
        }

        session()->flash('message', __('message.success_delete'));
        
    }

    public function copy($id)
    {
        $this->authorize($this->authorization['delete']);

        try {
            \DB::beginTransaction();
        
            $model = RoleModel::withTrashed()->find($id);

            $count = RoleModel::withTrashed()->where('name', $model->name)->count();

            $newModel = RoleModel::create([
                'uuid'=> Str::uuid(),
                'name'=> $model->name.'('.$count.')',
                'guard_name'=> $model->guard_name,
                'redirect'=> $model->redirect,
                'description'=> $model->description,
                'is_public'=> $model->is_public,
                'is_deleted'=> $model->is_deleted,
                'deleted_at'=> date('Y-m-d H:i:s'),
            ]);

            $rolePermissions = RolePermissionModel::where('role_id',$model->id)->get();

            foreach($rolePermissions as $row)
            {
                $row->replicate()->fill([
                    'uuid'=> Str::uuid(),
                    'role_id' => $newModel->id
                ])->save();
            }
        
            \DB::commit();

            session()->flash('message', __('message.success_created'));
        
        } catch (\Throwable $e) {
            \DB::rollback();

            session()->flash('error', $e->getMessage());
        }

      
        
    }

    public function show($id)
    {
        $this->authorize($this->authorization['show']);

        $this->dispatch('open-modal'); 

        $model = RoleModel::withTrashed()->find($id);
        
        $this->isViewOpen = true;
        $this->isNewRecord = false;
        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->name = $model->name;
        $this->guard_name = $model->guard_name;
        $this->is_public = $model->is_public;
        $this->redirect = $model->redirect;
        $this->description = $model->description;

        $rolePermissions = RolePermissionModel::where('role_id', $this->id)->get();
        $assigned = [];
        foreach($rolePermissions as $row){
            $assigned[$row->permission_id][] = $row->permission_id;
        }

        $groupPermissions = PermissionModel::select('id', 'controller', 'action')
        ->get();
        $group = [];
        foreach($groupPermissions as $row){
            $can = isset($assigned[$row->id]) ? true : false;
            $group[$row->controller][] = [
                'action'=>$row->action,
                'can'=>$can,
                'id'=>$row->id
            ];
        }


        $this->rolePermissions = $group;
    }

    public function permission($role_id, $permission_id)
    {
        $this->authorize($this->authorization['permission']);

        $isExists = RolePermissionModel::where('role_id', $role_id)->where('permission_id', $permission_id)->first();
        $role = RoleModel::find($role_id);
        // dd($role);
        if (!$isExists) {
            $role->permissions()->attach($permission_id, ['uuid' => Str::uuid()]);
            session()->flash('message', __('message.success_assign_permission'));
            
        } else {
            $role->permissions()->detach($permission_id);
            session()->flash('error', __('message.success_remove_permission'));
        }
    }
   
    public function search()
    {
        $this->resetPage();
    }

    // #[Layout('components.layouts.app')]
    public function render()
    {
        $this->authorize($this->authorization['index']);

        $model = RoleModel::withTrashed()->select("*")->when($this->is_deleted_q!="", function ($query)  {
            $query->where('is_deleted',$this->is_deleted_q);
        });

        $model->where(function ($query) {
            $query->where('name','like', '%' . $this->q . '%')
            ->orWhere('guard_name','like', '%' . $this->q . '%')
            ->orWhere('redirect','like', '%' . $this->q . '%');
        });

        $roles = $model->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        return view($this->view, [
            'models' => $roles,
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
        
    }
}
