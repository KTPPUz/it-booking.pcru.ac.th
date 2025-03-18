<?php

namespace App\Models;

use App\Models\Base\Equipment as BaseEquipment;

class Equipment extends BaseEquipment
{
	protected $fillable = [
		'equipment_code',
		'name',
		'status',
		'condition'
	];
}
