<?php

namespace App\Models;

use App\Models\Base\EquipmentStatus as BaseEquipmentStatus;

class EquipmentStatus extends BaseEquipmentStatus
{
	protected $fillable = [
		'name'
	];
}
