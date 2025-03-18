<?php

namespace App\Models;

use App\Models\Base\Notify as BaseNotify;

class Notify extends BaseNotify
{
	protected $fillable = [
		'notify_type',
		'notify_uid',
		'notify_status',
		'is_staff'
	];
}
