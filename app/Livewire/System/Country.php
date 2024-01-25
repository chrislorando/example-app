<?php

namespace App\Livewire\System;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Models\Country AS CountryModel;
use Illuminate\Validation\Rule;

class Country extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;

    public $layout = "components.layouts.app";
    public $view = "livewire.system.country";
    public $pageTitle = "label.country";

    // #[Url(keep: true)] 
    public $q = "";
    public $is_deleted_q;
    public $sortField = "id";
    public $sortDirection = "asc";
    public $perPage = 10;

    public $queryString = ['q', 'is_deleted_q', 'sortField', 'sortDirection'];

    public $authorization = [
        'index'=>'system.country.index',
        'create'=>'system.country.create',
        'store'=>'system.country.store',
        'edit'=>'system.country.edit',
        'update'=>'system.country.update',
        'delete'=>'system.country.delete',
        'deletePhoto'=>'system.country.deletePhoto',
        'restore'=>'system.country.restore'
    ];


    public $isFormOpen = false;

    public $isViewOpen = false;

    public $isNewRecord = true;

    public $id, $uuid;

    public $code;

    public $name;

    public $flag;

    public $photo;

    public $photo_upload;

    public $is_deleted;

    protected array $rules = [];
    protected function rules() 
    {
        return [
            'code' => [
                'required',
                'min:2',
                Rule::unique('countries')->ignore($this->id)
            ],
            'name' => 'required|min:2',
            'photo_upload' => 'nullable|image|max:1024',
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
            return $this->redirect('/system/country', navigate: true);
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
            'code'=> $this->code,
            'name'=> $this->name,
        ];

        if($this->photo_upload){

            $newFile = Helper::uploadFile('', $this->photo_upload, '', 'photos');

            $data['flag'] = $newFile;

        }

        if($this->is_deleted){
            $data['is_deleted'] = '1';
        }else{
            $data['is_deleted'] = '0';
        }
   
        $model = CountryModel::create($data);

        if($model){
            session()->flash('message', __('message.success_create'));
            $this->q = $this->name;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');         
        }else{
            session()->flash('message', __('message.error_create'));
        }

 
    }

    public function edit(CountryModel $model)
    {
        $this->authorize($this->authorization['edit']);

        $this->reset();
        $this->isFormOpen = true;
        $this->dispatch('open-modal'); 

        $this->isNewRecord = false;
        
        $this->id = $model->id;
        $this->uuid = $model->uuid;
        $this->code = $model->code;
        $this->name = $model->name;
        $this->flag = $model->flag ? $model->flag : "";
        $this->is_deleted = $model->is_deleted;
    }

    public function update()
    {
        $this->authorize($this->authorization['update']);

        $this->validate();

        $data = [
            'code'=> $this->code,   
            'name'=> $this->name,   
        ];

        if($this->photo_upload){

            $newFile = Helper::uploadFile($this->flag, $this->photo_upload, strtolower($this->name).'_'.date('YmdHis'), 'photos');

            if($newFile){
                $data['flag'] = $newFile;
                $this->flag = $data['flag'];
            }
            
        }

        if($this->is_deleted){
            $data['is_deleted'] = '1';
        }else{
            $data['is_deleted'] = '0';
        }
   
        $model = CountryModel::where('uuid', $this->uuid)->update($data);

        if($model){
            session()->flash('message', __('message.success_update'));
            // $this->reset();
            $this->q = $this->name;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');        
        }else{
            session()->flash('message', __('message.error_update'));
        }
    }

    public function restore($id)
    {
        $this->authorize($this->authorization['restore']);

        $model = CountryModel::withTrashed()->find($id);

        $model->is_deleted = '0';
        $model->save();
        $model->restore();

        session()->flash('message', __('message.success_restore'));
    }

    public function delete($id)
    {
        $this->authorize($this->authorization['delete']);

        $model = CountryModel::withTrashed()->find($id);

        if($model->trashed()){
            $model->forceDelete();
        }else{
            $model->is_deleted = '1';
            $model->save();
            $model->delete();
        }

        session()->flash('message', __('message.success_delete'));
        
    }
    
    public function deletePhoto(CountryModel $model)
    {
        $this->authorize($this->authorization['deletePhoto']);

        if($model){
            Helper::deleteFile($model->flag, 'photos');
            $this->flag = "";
            $model->flag = "";
            $model->save();
        }

        if($this->photo_upload){
            $this->photo_upload = null;
        }
        
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize($this->authorization['index']);

        $countries = CountryModel::withTrashed()->select("*")->when($this->is_deleted_q!="", function ($query)  {
            $query->where('is_deleted',$this->is_deleted_q);
        });

        $countries->where(function ($query) {
            $query->where('code','like', '%' . $this->q . '%')
            ->orWhere('name','like', '%' . $this->q . '%');
        });

        $models = $countries->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        return view($this->view, [
            'models' => $models,
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
    }
}
