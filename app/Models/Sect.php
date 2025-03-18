<?php

namespace App\Models;

use App\Models\Base\Sect as BaseSect;

class Sect extends BaseSect
{
	protected $fillable = [
		'department_code',
		'sect_code',
		'sect_name',
		'sect_status'
	];
}
