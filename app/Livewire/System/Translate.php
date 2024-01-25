<?php

namespace App\Livewire\System;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Models\Translate AS TranslateModel;
use App\Models\Country AS CountryModel;
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
    public $sortField = "code";
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
        'restore'=>'system.translate.restore',
        'publish'=>'system.translate.publish',
        'backup'=>'system.translate.backup'
    ];


    public $isFormOpen = false;

    public $isViewOpen = false;

    public $isNewRecord = true;

    public $id, $uuid;

    public $locale;

    public $group;

    public $parent;

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
                Rule::unique('translates')->where(function ($query) {
                    return $query->where('locale', $this->locale)
                        ->where('group', $this->group)
                       ->where('value', $this->code);
                })->ignore($this->id)
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
            'parent'=> $this->parent,
            'code'=> $this->code,
            'value'=> $this->value,
        ];

     
        $model = TranslateModel::create($data);

        if($model){
            session()->flash('message', __('message.success_create'));
            $this->q = $this->code;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');         
        }else{
            session()->flash('message', __('message.error_create'));
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
        $this->parent = $model->parent;
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
            'parent'=> $this->parent,
            'code'=> $this->code,
            'value'=> $this->value, 
        ];

        $model = TranslateModel::withTrashed()->find($this->id)->update($data);

        if($model){
            session()->flash('message', __('message.success_update'));
            // $this->reset();
            $this->q = $this->code;
            $this->isFormOpen = false;
            $this->dispatch('close-modal');        
        }else{
            session()->flash('message', __('message.error_update'));
        }
    }

    public function restore($id)
    {
        $this->authorize($this->authorization['restore']);

        $model = TranslateModel::withTrashed()->find($id);

        $model->is_deleted = '0';
        $model->save();
        $model->restore();

        session()->flash('message', __('message.success_restore'));
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
        
        session()->flash('message', __('message.success_delete'));
    }

    public function publish()
    {
        $this->authorize($this->authorization['publish']);

        $array = [];
        $translates = TranslateModel::get();

        foreach($translates as $translate){
            if($translate->parent==null){
                $array[$translate->locale][$translate->group][$translate->code] = $translate->value;
            }else{
                $array[$translate->locale][$translate->group][$translate->parent][$translate->code] = $translate->value;
            }
           
        }

        foreach($array as $key=>$row){

            foreach($row as $k=>$r){
                $dir = base_path() . '/lang/'.$key.'/';
                $filename = base_path() . '/lang/'.$key.'/'.$k.'.php';

                if (!is_dir($dir)) {
                    mkdir($dir, 0755);
                }else{
                    $array_string = Helper::var_export_custom($r, true);
                    file_put_contents($filename, "<?php\n\n\rreturn $array_string;\n\n");

                }
            }   
        }

        session()->flash('message', __('message.published'));
    }
    
    public function backup()
    {
        $path = base_path() . '/lang/';

        $data = Helper::listFile($path);
        
        $array = [];
        foreach($data as $locales=>$groups){
            if(is_countable($groups)){
                foreach($groups as $locale=>$group){
                    $langFile = str_replace(".php", "", $group);
                    $strarray = include(base_path()."/lang/".$locales.'/'.$group);
                    foreach($strarray as $key=>$row){
                        if(is_countable($row)){
                            foreach($row as $k=>$r){
                                $uuid = Str::uuid()->toString();
                                $isExists = TranslateModel::where('locale',$locales)->where('group',$langFile)->where('code',$k)->count();
                                if($isExists <= 0){
                                    $array[] = [
                                        'uuid'=> $uuid,
                                        'locale'=> $locales,
                                        'group'=> $langFile,
                                        'parent'=>$key,
                                        'code'=> $k,
                                        'value'=> $r,
                                    ];
                                }
                             
                            }
                        }else{
                            $uuid = Str::uuid()->toString();
                            $isExists = TranslateModel::where('locale',$locales)->where('group',$langFile)->where('code',$key)->count();
                            if($isExists <= 0){
                                $array[] = [
                                    'uuid'=> $uuid,
                                    'locale'=> $locales,
                                    'group'=> $langFile,
                                    'parent'=> null,
                                    'code'=> $key,
                                    'value'=>$row,
                                ];
                            }
                        
                        }
                    }
                }
            }         
        }

        TranslateModel::insert($array);

        session()->flash('message', __('message.done_backup'));
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize($this->authorization['index']);

        $translates = TranslateModel::withTrashed()->select("*")->when($this->is_deleted_q!="", function ($query)  {
            $query->where('is_deleted',$this->is_deleted_q);
        });

        $translates->where(function ($query) {
            $query->where('locale','like', '%' . $this->q . '%')
            ->orWhere('group','like', '%' . $this->q . '%')
            ->orWhere('parent','like', '%' . $this->q . '%')
            ->orWhere('code','like', '%' . $this->q . '%')
            ->orWhere('value','like', '%' . $this->q . '%');
        });

        $models = $translates->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        $countryModel = CountryModel::get();
        $countries = [];
        foreach($countryModel as $r){
            $countries[] = [
                'value'=> $r->code,
                'text'=> $r->name
            ];
        }

        return view($this->view, [
            'countries'=>$countries,
            'models' => $models,
        ])
        ->title(__($this->pageTitle))
        ->layout($this->layout);
    }
}
