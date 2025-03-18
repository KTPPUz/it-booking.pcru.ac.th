<?php

namespace App\Models;

use App\Models\Base\EquipmentMaintenance as BaseEquipmentMaintenance;

class EquipmentMaintenance extends BaseEquipmentMaintenance
{
	protected $fillable = [
		'equipment_id',
		'start_date',
		'end_date',
		'description'
	];
}
