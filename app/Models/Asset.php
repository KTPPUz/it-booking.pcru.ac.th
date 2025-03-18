<?php

namespace App\Models;

use App\Models\Base\Asset as BaseAsset;
use App\Models\AssetGroup;

class Asset extends BaseAsset
{
	protected $fillable = [
		'group_id',
		'asset_ac_id',
		'asset_status',
		'asset_note'
	];

	public function assetGroup()
	{
		return $this->belongsTo(AssetGroup::class, 'group_id');
	}
}