<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Asset;
use App\Models\Department;
use App\Models\Room;
use App\Models\Sect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AssetLocation
 *
 * @property int $location_id
 * @property int|null $asset_id
 * @property int|null $room_id
 * @property int|null $department_id
 * @property int|null $sect_id
 * @property string|null $location_type
 * @property bool|null $is_current
 * @property Carbon|null $moved_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property Asset|null $asset
 * @property Room|null $room
 * @property Department|null $department
 * @property Sect|null $sect
 *
 * @package App\Models\Base
 */
class AssetLocation extends Model
{
	protected $table = 'asset_location';
	protected $primaryKey = 'location_id';

	protected $casts = [
		'asset_id' => 'int',
		'room_id' => 'int',
		'department_id' => 'int',
		'sect_id' => 'int',
		'location_type' => 'string',
		'is_current' => 'int',
		'moved_at' => 'datetime'
	];

	public function asset()
	{
		return $this->belongsTo(Asset::class);
	}

	public function room()
	{
		return $this->belongsTo(Room::class);
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function sect()
	{
		return $this->belongsTo(Sect::class);
	}
}