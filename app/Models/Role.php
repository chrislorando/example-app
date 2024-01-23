<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'guard_name',
        'redirect',
        'is_public',
        'description',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function getIsPublicText() {
        if($this->is_public==0){
            return 'Private';
        }else if($this->is_public==1){
            return 'Public';
        }else{
            return '';
        }
    }

    public function getIsActiveText() {
        if($this->is_deleted==0){
            return 'No';
        }else if($this->is_deleted==1){
            return 'Yes';
        }else{
            return '';
        }
    }
}
