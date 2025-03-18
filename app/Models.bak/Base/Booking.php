<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Department;
use App\Models\Room;
use App\Models\RoomSchedule;
use App\Models\Sect;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 *
 * @property int $booking_id
 * @property int|null $user_id
 * @property int|null $department_id
 * @property int|null $sect_id
 * @property string|null $reason
 * @property bool $is_ext
 * @property bool $is_classroom
 * @property Carbon|null $sent_dt
 * @property int|null $reviewer_id
 * @property int|null $review_status
 * @property Carbon|null $review_dt
 * @property string|null $review_comment
 * @property string|null $cancel_reason
 * @property Carbon|null $canceled_at
 * @property bool|null $doc_status
 * @property bool|null $doc_state
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property User|null $user
 * @property Department|null $department
 * @property Sect|null $sect
 * @property Collection|Room[] $rooms
 * @property Collection|RoomSchedule[] $room_schedules
 *
 * @package App\Models\Base
 */
class Booking extends Model
{
	protected $table = 'booking';
	protected $primaryKey = 'booking_id';

	protected $casts = [
		'user_id' => 'int',
		'department_id' => 'int',
		'sect_id' => 'int',
		'is_ext' => 'int',
		'is_classroom' => 'int',
		'sent_dt' => 'datetime',
		'reviewer_id' => 'int',
		'review_status' => 'int',
		'review_dt' => 'datetime',
		'canceled_at' => 'datetime',
		'doc_status' => 'int',
		'doc_state' => 'int'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function sect()
	{
		return $this->belongsTo(Sect::class);
	}

	public function rooms()
	{
		return $this->belongsToMany(Room::class)
					->withPivot('no', 'participant_count', 'date', 'time_start', 'time_end');
	}

	public function room_schedules()
	{
		return $this->hasMany(RoomSchedule::class);
	}
}
