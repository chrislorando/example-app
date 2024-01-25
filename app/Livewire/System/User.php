<?php

namespace App\Livewire\System;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Component;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Models\User AS UserModel;
use App\Models\Role AS RoleModel;
use Illuminate\Validation\Rule;

class User extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;

    public $layout = "components.layouts.app";
    public $view = "livewire.system.user";
    public $pageTitle = "label.user";

    // #[Url(keep: true)] 
    public $q = "";
    public $is_deleted_q;
    public $sortField = "id";
    public $sortDirection = "asc";
    public $perPage = 10;

    public $queryString = ['q', 'is_deleted_q', 'sortField', 'sortDirection'];

    public $authorization = [
        'index'=>'system.user.index',
        'create'=>'system.user.create',
        'store'=>'system.user.store',
        'edit'=>'system.user.edit',
        'update'=>'system.user.update',
        'delete'=>'system.user.delete',
        'restore'=>'system.user.restore',
        'deletePhoto'=>'system.user.deletePhoto',
        'show'=>'system.user.show',
    ];


    public $isFormOpen = false;

    public $isViewOpen = false;

    public $isNewRecord = true;

    public $id, $uuid;

    public $name;

    public $username;

    public $email;

    public $password;

    public $password_confirmation;

    public $role_id;

    public $photo;

    public $photo_upload;

    public $is_deleted;

    protected array $rules = [];
    
    protected function rules() 
    {
        return [
            'name' => 'required|min:2',
            'username' => [
                'required',
                'min:4',
                Rule::unique('users')->ignore($this->id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id)
            ],
            'password' => 'required|min:6|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
            'role_id' => 'required|numeric',
            'photo_upload' => 'nullable|image|max:1024',
            // 'is_deleted' => 'numeric',
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
            'name'=> $this->name,
            'username'=> $this->username,
            'email'=> $this->email,
            'password'=> bcrypt($this->password),
            'role_id'=> $this->role_id,
        ];

        if($this->photo_upload){

            $newFile = Helper::uploadFile('', $this->photo_upload, '', 'photos');

            $data['photo'] = $newFile;

        }

        if($this->is_deleted){
            $data['is_deleted'] = '1';
        }else{
            $data['is_deleted'] = '0';
        }
   
        $model = UserModel::create($data);

        if($model){
            session()->flash('message', __('message.success_create'));
            $this->q = $this->username;
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

        $model = UserModel::withTrashed()->find($id);
        
        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->name = $model->name;
        $this->username = $model->username;
        $this->email = $model->email;
        $this->password = '********';
        $this->password_confirmation = '********';
        $this->role_id = $model->role_id;
        $this->photo = $model->photo ? $model->photo : "";
        $this->is_deleted = $model->is_deleted;
    }

    public function update()
    {
        $this->authorize($this->authorization['update']);

        $this->validate();

        $data = [
            'name'=> $this->name,   
            'username'=> $this->username,   
            'email'=> $this->email, 
            'role_id'=> $this->role_id,
        ];

        if($this->photo_upload){
          
            $newFile = Helper::uploadFile($this->photo, $this->photo_upload, strtolower($this->username).'_'.date('YmdHis'), 'photos');

            if($newFile){
                $data['photo'] = $newFile;
                $this->photo = $data['photo'];
            }
            
        }

        if($this->is_deleted){
            $data['is_deleted'] = '1';
        }else{
            $data['is_deleted'] = '0';
        }
   

        if($this->password != '********'){
            $data['password'] = bcrypt($this->password);
        }
     
        $model = UserModel::withTrashed()->find($this->id)->update($data);

        if($model){
            session()->flash('message', __('message.success_update'));
            // $this->reset();
            $this->q = $this->username;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');        
        }else{
            session()->flash('error', __('message.error_update'));
        }
    }

    public function delete($id)
    {
        $this->authorize($this->authorization['delete']);

        $model = UserModel::withTrashed()->find($id);

        if($model->trashed()){
            $model->forceDelete();
        }else{
            $model->is_deleted = '1';
            $model->save();
            $model->delete();
        }

        session()->flash('message', __('message.success_delete'));
    }

    public function restore($id)
    {
        $this->authorize($this->authorization['restore']);

        $model = UserModel::withTrashed()->find($id);

        $model->is_deleted = '0';
        $model->save();
        $model->restore();

        session()->flash('message', __('message.success_restore'));
    }
    
    public function deletePhoto(UserModel $model)
    {
        $this->authorize($this->authorization['deletePhoto']);

        if($model){
            Helper::deleteFile($model->photo, 'photos');
            $this->photo = "";
            $model->photo = "";
            $model->save();
        }

        if($this->photo_upload){
            $this->photo_upload = null;
        }
        
    }

    public function show($id)
    {
        $this->authorize($this->authorization['show']);

        $this->dispatch('open-modal'); 

        $model = UserModel::withTrashed()->find($id);
        
        $this->isViewOpen = true;
        $this->isNewRecord = false;
        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->name = $model->name;
        $this->username = $model->username;
        $this->email = $model->email;
        $this->role_id = $model->role_id;
        $this->photo = $model->photo ? $model->photo : "";
        $this->is_deleted = $model->is_deleted;
    }

    public function search()
    {
        $this->resetPage();
    }

    // #[Layout('components.layouts.app')]
    public function render()
    {
        $this->authorize($this->authorization['index']);

        $model = UserModel::withTrashed()->select("*")->when($this->is_deleted_q!="", function ($query)  {
            $query->where('is_deleted',$this->is_deleted_q);
        });

        $model->where(function ($query) {
            $query->where('username','like', '%' . $this->q . '%')
            ->orWhere('name','like', '%' . $this->q . '%')
            ->orWhere('email','like', '%' . $this->q . '%');
        });

        $users = $model->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        $roleModel = RoleModel::get();
        $roles = [];
        foreach($roleModel as $r){
            $roles[] = [
                'value'=> $r->id,
                'text'=> $r->name
            ];
        }

        return view($this->view, [
            'users' => $users,
            'roles' => $roles
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
        
    }
}
