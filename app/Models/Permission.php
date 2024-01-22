<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'guard_name',
        'controller',
        'action',
        'method',
        'params',
        'alias',
        'description',
    ];
}
