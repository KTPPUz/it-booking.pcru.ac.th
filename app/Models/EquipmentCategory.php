<?php

namespace App\Models;

use App\Models\Base\EquipmentCategory as BaseEquipmentCategory;

class EquipmentCategory extends BaseEquipmentCategory
{
	protected $fillable = [
		'name',
		'status'
	];
}
