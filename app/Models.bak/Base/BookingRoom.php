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
 * Class BookingRoom
 *
 * @property int $booking_id
 * @property int $no
 * @property int $room_id
 * @property int $participant_count
 * @property Carbon $date
 * @property Carbon $time_start
 * @property Carbon $time_end
 *
 * @property Room $room
 * @property Booking $booking
 *
 * @package App\Models\Base
 */
class BookingRoom extends Model
{
	protected $table = 'booking_room';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'booking_id' => 'int',
		'no' => 'int',
		'room_id' => 'int',
		'participant_count' => 'int',
		'date' => 'datetime',
		'time_start' => 'datetime',
		'time_end' => 'datetime'
	];

	public function room()
	{
		return $this->belongsTo(Room::class);
	}

	public function booking()
	{
		return $this->belongsTo(Booking::class, 'booking_id');
	}

}
