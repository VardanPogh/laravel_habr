<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'last_name', 'username', 'address',
        'tel', 'business_name', 'name_of_store',
        'province', 'vat_number', 'cap',
        'common', 'status', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(UserRoles::class, 'id', 'role_id');
    }

    public static function is_Admin()
    {
        if(Auth::user()->role->name == 'admin'){
            return true;
        }

        return false;
    }
    public static function is_SuperAdmin()
    {
        if(Auth::user()->role->name == 'superadmin'){
            return true;
        }

        return false;
    }

    public static function is_Agent()
    {
        if(Auth::user()->role->name == 'agent'){
            return true;
        }

        return false;
    }

    public static function is_User()
    {
        if(Auth::user()->role->name == 'user'){
            return true;
        }

        return false;
    }

    public function transacrtions(){
        return $this->hasMany(Transaction::class, 'admin_id', 'id');
    }
}
