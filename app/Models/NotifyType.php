<?php

namespace App\Models;

use App\Models\Base\NotifyType as BaseNotifyType;

class NotifyType extends BaseNotifyType
{
	protected $fillable = [
		'name',
		'target',
		'key',
		'status'
	];
}
