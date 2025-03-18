<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Department;
use App\Models\Equipment;
use App\Models\Room;
use App\Models\Sect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentLocation
 * 
 * @property int $location_id
 * @property int $equipment_id
 * @property string $location_type
 * @property string|null $location
 * @property int|null $room_id
 * @property int|null $sect_id
 * @property int|null $dept_id
 * @property bool $is_current
 * @property Carbon|null $moved_at
 * 
 * @property Department|null $department
 * @property Equipment $equipment
 * @property Room|null $room
 * @property Sect|null $sect
 *
 * @package App\Models\Base
 */
class EquipmentLocation extends Model
{
	protected $table = 'equipment_location';
	protected $primaryKey = 'location_id';
	public $timestamps = false;

	protected $casts = [
		'equipment_id' => 'int',
		'room_id' => 'int',
		'sect_id' => 'int',
		'dept_id' => 'int',
		'is_current' => 'bool',
		'moved_at' => 'datetime'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'dept_id');
	}

	public function equipment()
	{
		return $this->belongsTo(Equipment::class);
	}

	public function room()
	{
		return $this->belongsTo(Room::class);
	}

	public function sect()
	{
		return $this->belongsTo(Sect::class);
	}
}
