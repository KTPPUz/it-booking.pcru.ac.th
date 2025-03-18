<?php

namespace App\Models;

use App\Models\Base\Prefix as BasePrefix;

class Prefix extends BasePrefix
{
	protected $fillable = [
		'prefix_name',
		'prefix_status'
	];
}
