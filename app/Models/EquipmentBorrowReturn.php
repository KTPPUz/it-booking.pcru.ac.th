<?php

namespace App\Models;

use App\Models\Base\EquipmentBorrowReturn as BaseEquipmentBorrowReturn;

class EquipmentBorrowReturn extends BaseEquipmentBorrowReturn
{
	protected $fillable = [
		'borrow_id',
		'equipment_id',
		'return_date',
		'return_condition'
	];
}
