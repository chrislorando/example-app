<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'locale',
        'group',
        'parent',
        'code',
        'value',
        'is_attributes',
        'is_deleted'
    ];

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
