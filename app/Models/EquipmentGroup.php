<?php

namespace App\Models;

use App\Models\Base\EquipmentGroup as BaseEquipmentGroup;

class EquipmentGroup extends BaseEquipmentGroup
{
	protected $fillable = [
		'category_id',
		'code',
		'name',
		'budget_source',
		'acquisition_year',
		'status'
	];
}
