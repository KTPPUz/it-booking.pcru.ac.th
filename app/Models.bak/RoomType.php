<?php

namespace App\Models;

use App\Models\Base\RoomType as BaseRoomType;

class RoomType extends BaseRoomType
{
	protected $fillable = [
		'name',
		'status'
	];
}
