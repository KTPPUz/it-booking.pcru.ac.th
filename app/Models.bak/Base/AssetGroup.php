<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Asset;
use App\Models\AssetType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AssetGroup
 * 
 * @property int $group_id
 * @property string|null $group_name
 * @property int|null $asset_type_id
 * @property int|null $group_status
 * @property string|null $specifications
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property AssetType|null $asset_type
 * @property Collection|Asset[] $assets
 *
 * @package App\Models\Base
 */
class AssetGroup extends Model
{
	protected $table = 'asset_group';
	protected $primaryKey = 'group_id';

	protected $casts = [
		'asset_type_id' => 'int',
		'group_status' => 'int'
	];

	public function asset_type()
	{
		return $this->belongsTo(AssetType::class);
	}

	public function assets()
	{
		return $this->hasMany(Asset::class, 'group_id');
	}
}
