<?php

namespace App\Models;

use App\Models\Base\EquipmentBorrowDetail as BaseEquipmentBorrowDetail;

class EquipmentBorrowDetail extends BaseEquipmentBorrowDetail
{
	protected $fillable = [
		'borrow_id',
		'equipment_id',
		'status'
	];
}
