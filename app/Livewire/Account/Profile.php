<?php

namespace App\Livewire\Account;

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

class Profile extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;

    public $layout = "components.layouts.app";
    public $view = "livewire.account.profile";
    public $pageTitle = "label.profile";

    public $authorization = [
        'index'=>'account.profile.index',
        'update'=>'account.profile.update',
        'updatePassword'=>'account.profile.updatePassword',
        'deletePhoto'=>'account.profile.deletePhoto',
    ];

    public $id, $uuid;

    public $name;

    public $username;

    public $email;

    public $password;

    public $password_confirmation;

    public $role_id;

    public $photo;

    public $photo_upload;

    protected array $rules = [];
    
    protected function rules() 
    {
        return [
            'name' => 'required|min:2',
           
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id)
            ],
            'password' => 'required|min:6|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
            'photo_upload' => 'nullable|image|max:1024',
            // 'is_deleted' => 'numeric',
        ];
    }

    public function mount()
    {
        $this->rules = $this->rules();
    }

    public function update()
    {
        $this->authorize($this->authorization['update']);


        $this->validate();

        $data = [
            'name'=> $this->name,   
            'email'=> $this->email, 
        ];

        if($this->photo_upload){
          
            $newFile = Helper::uploadFile($this->photo, $this->photo_upload, strtolower($this->username).'_'.date('YmdHis'), 'photos');

            if($newFile){
                $data['photo'] = $newFile;
                $this->photo = $data['photo'];
            }
            
        }

     
        $model = UserModel::find($this->id)->update($data);


        if($model){
            session()->flash('message', __('message.success_update'));
            
        }else{
            session()->flash('error', __('message.error_update'));
        }
    }

    public function updatePassword()
    {
        $this->authorize($this->authorization['update']);


        $this->validate();

     
        $model = UserModel::find($this->id);

        if($this->password != '********'){
            $data['password'] = bcrypt($this->password);

            $model->update($data);
        }


        if($model){
            session()->flash('message', __('message.success_update'));
            
        }else{
            session()->flash('error', __('message.error_update'));
        }
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

    public function render()
    {
        $this->authorize($this->authorization['index']);

        $model = UserModel::find(\Auth::user()->id);

        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->name = $model->name;
        $this->username = $model->username;
        $this->email = $model->email;
        $this->password = '********';
        $this->password_confirmation = '********';
        $this->role_id = $model->role->name;
        $this->photo = $model->photo ? $model->photo : "";
        $this->is_deleted = $model->is_deleted;
        
        return view($this->view, [
            'model' => $model,
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
    }
}
