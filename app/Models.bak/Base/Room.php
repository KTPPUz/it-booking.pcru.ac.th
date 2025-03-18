<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\AssetLocation;
use App\Models\Booking;
use App\Models\RoomSchedule;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Room
 *
 * @property int $room_id
 * @property int|null $room_type
 * @property string|null $room_name
 * @property int|null $capacity
 * @property string|null $room_pic
 * @property string|null $description
 * @property bool|null $status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property Collection|AssetLocation[] $asset_locations
 * @property Collection|Booking[] $bookings
 * @property Collection|RoomSchedule[] $room_schedules
 *
 * @package App\Models\Base
 */
class Room extends Model
{
	protected $table = 'room';
	protected $primaryKey = 'room_id';

	protected $casts = [
		'room_type' => 'int',
		'capacity' => 'int',
		'status' => 'int'
	];

	public function room_type()
	{
		return $this->belongsTo(RoomType::class, 'room_type');
	}

	public function asset_locations()
	{
		return $this->hasMany(AssetLocation::class);
	}

	public function bookings()
	{
		return $this->belongsToMany(Booking::class)
					->withPivot('no', 'participant_count', 'date', 'time_start', 'time_end');
	}

	public function room_schedules()
	{
		return $this->hasMany(RoomSchedule::class);
	}
}
