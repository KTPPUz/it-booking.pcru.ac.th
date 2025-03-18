<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\AssetGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AssetType
 * 
 * @property int $type_id
 * @property string|null $type_name
 * @property string|null $description
 * @property int|null $status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property Collection|AssetGroup[] $asset_groups
 *
 * @package App\Models\Base
 */
class AssetType extends Model
{
	protected $table = 'asset_type';
	protected $primaryKey = 'type_id';

	protected $casts = [
		'status' => 'int'
	];

	public function asset_groups()
	{
		return $this->hasMany(AssetGroup::class);
	}
}
