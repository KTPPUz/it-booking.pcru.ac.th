<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomSchedule
 *
 * @property int $schedule_id
 * @property int|null $booking_id
 * @property int|null $room_id
 * @property Carbon|null $dt_start
 * @property Carbon|null $dt_end
 * @property bool|null $status
 * @property string|null $calendar_event_id
 * @property bool|null $calendar_status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property Room|null $room
 * @property Booking|null $booking
 *
 * @package App\Models\Base
 */
class RoomSchedule extends Model
{
	protected $table = 'room_schedule';
	protected $primaryKey = 'schedule_id';

	protected $casts = [
		'booking_id' => 'int',
		'room_id' => 'int',
		'dt_start' => 'datetime',
		'dt_end' => 'datetime',
		'status' => 'int',
		'calendar_status' => 'int'
	];

	public function room()
	{
		return $this->belongsTo(Room::class);
	}

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}
}
