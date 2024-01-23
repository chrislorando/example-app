<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'parent_id',
        'sequence',
        'code',
        'name',
        'translate',
        'description',
        'icon',
        'url',
        'position',
        'is_deleted'
    ];

    public function parent() {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function getIsActiveText() {
        if($this->is_deleted=='0'){
            return 'No';
        }else if($this->is_deleted=='1'){
            return 'Yes';
        }else{
            return '';
        }
    }

    public function getPositionText() {
        if($this->position==0){
            return 'Header';
        }else if($this->position==1){
            return 'Sidebar';
        }else{
            return '';
        }
    }
    
}
