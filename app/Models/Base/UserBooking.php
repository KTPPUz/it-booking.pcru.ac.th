<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserBooking
 * 
 * @property int $user_id
 * @property int $room_id
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon $ubooking_date
 * @property Carbon|null $ubooking_timestart
 * @property Carbon|null $ubooking_timeend
 * @property int $participant_count
 * @property int $no
 *
 * @package App\Models\Base
 */
class UserBooking extends Model
{
	protected $table = 'user_booking';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int',
		'room_id' => 'int',
		'status' => 'int',
		'ubooking_date' => 'datetime',
		'ubooking_timestart' => 'datetime',
		'ubooking_timeend' => 'datetime',
		'participant_count' => 'int',
		'no' => 'int'
	];
}
