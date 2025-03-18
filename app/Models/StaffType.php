<?php

namespace App\Models;

use App\Models\Base\StaffType as BaseStaffType;

class StaffType extends BaseStaffType 
{
 
    protected $fillable = [
        'name',
    ];
}