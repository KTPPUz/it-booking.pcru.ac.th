<?php

namespace App\Models;

use App\Models\Base\AssetGroup as BaseAssetGroup;
use App\Models\AssetType;

class AssetGroup extends BaseAssetGroup
{
	protected $fillable = [
		'group_name',
		'asset_type_id',
		'group_status',
		'specifications'
	];

	public function assetType()
	{
		return $this->belongsTo(AssetType::class , 'asset_type_id');
	}
}