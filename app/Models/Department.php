<?php

namespace App\Models;

use App\Models\Base\Department as BaseDepartment;

class Department extends BaseDepartment
{
	protected $fillable = [
		'department_code',
		'department_name',
		'department_status'
	];
}
