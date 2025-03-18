<?php

namespace App\Models;

use App\Models\Base\AssetType as BaseAssetType;

class AssetType extends BaseAssetType
{
	protected $fillable = [
		'type_name',
		'description',
		'status'
	];
}
