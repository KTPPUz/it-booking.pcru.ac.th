<?php

namespace App\Models;

use App\Models\Base\EquipmentUsage as BaseEquipmentUsage;

class EquipmentUsage extends BaseEquipmentUsage
{
	protected $fillable = [
		'equipment_id',
		'usage_date',
		'borrow_id'
	];
}
