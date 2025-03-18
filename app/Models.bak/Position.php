<?php

namespace App\Models;

use App\Models\Base\Position as BasePosition;

class Position extends BasePosition
{
	protected $fillable = [
		'position_code',
		'position_name',
		'status'
	];
}
