<?php

namespace App\Models;

use App\Models\Base\StaffUser as BaseStaffUser;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use App\Models\StaffType;

class StaffUser extends BaseStaffUser implements AuthenticatableContract
{
    use Authenticatable;
    
   

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'department_id',
        'sect_id',
        'type_id'
    ];

    public function stafftype(){
        return $this->belongsTo(StaffType::class, 'type_id' , 'staff_type_id');
    }
}