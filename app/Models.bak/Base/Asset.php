<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\AssetGroup;
use App\Models\AssetLocation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Asset
 * 
 * @property int $asset_id
 * @property int|null $group_id
 * @property string $asset_ac_id
 * @property int|null $asset_status
 * @property string|null $asset_note
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property AssetGroup|null $asset_group
 * @property Collection|AssetLocation[] $asset_locations
 *
 * @package App\Models\Base
 */
class Asset extends Model
{
	protected $table = 'asset';
	protected $primaryKey = 'asset_id';

	protected $casts = [
		'group_id' => 'int',
		'asset_status' => 'int'
	];

	public function asset_group()
	{
		return $this->belongsTo(AssetGroup::class, 'group_id');
	}

	public function asset_locations()
	{
		return $this->hasMany(AssetLocation::class);
	}
}
