<?php

namespace App\Models;

use App\Models\Base\EquipmentBorrow as BaseEquipmentBorrow;

class EquipmentBorrow extends BaseEquipmentBorrow
{
	protected $fillable = [
		'borrower_name',
		'borrow_date',
		'expect_return_date',
		'status',
		'sect_id',
		'dept_id',
		'staff_user'
	];
}
