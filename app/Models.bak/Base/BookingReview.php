<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Booking;
use App\Models\StaffUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingReview
 *
 * @property int $review_id
 * @property int|null $booking_id
 * @property int|null $reviewer_id
 * @property bool|null $review_status
 * @property Carbon|null $review_dt
 * @property string|null $review_comment
 * @property Carbon|null $upcated_at
 * @property Carbon|null $created_at
 *
 * @property Booking|null $booking
 * @property StaffUser|null $staff_user
 *
 * @package App\Models\Base
 */
class BookingReview extends Model
{
	protected $table = 'booking_review';
	protected $primaryKey = 'review_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'review_id' => 'int',
		'booking_id' => 'int',
		'reviewer_id' => 'int',
		'review_status' => 'int',
		'review_dt' => 'datetime',
		'upcated_at' => 'datetime'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function staff_user()
	{
		return $this->belongsTo(StaffUser::class, 'reviewer_id');
	}
}
