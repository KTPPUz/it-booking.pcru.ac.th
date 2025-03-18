<?php

namespace App\Models;

use App\Models\Base\EquipmentLocation as BaseEquipmentLocation;

class EquipmentLocation extends BaseEquipmentLocation
{
	protected $fillable = [
		'equipment_id',
		'location_type',
		'location',
		'room_id',
		'sect_id',
		'dept_id',
		'is_current',
		'moved_at'
	];
}
