<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    const IS_DELETED = true;

    protected static function boot()
    {
        parent::boot();
 
        // static::addGlobalScope('all', function (Builder $builder) {
        //     $builder->whereIn('is_deleted', ['0','1']);
        // });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'photo',
        'is_deleted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission) {
        return $this->role->permissions()->where('name', $permission)->first() ?: false;
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

    public function isNotBanned(){
        if($this->is_deleted=='0'){
            return true;
        }else if($this->is_deleted=='1'){
            return false;
        }else{
            return false;
        }
    }
}
