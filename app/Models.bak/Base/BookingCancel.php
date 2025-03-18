<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingCancel
 * 
 * @property int $booking_id
 * @property string|null $reason
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property Booking $booking
 *
 * @package App\Models\Base
 */
class BookingCancel extends Model
{
	protected $table = 'booking_cancel';
	protected $primaryKey = 'booking_id DESC';
	public $incrementing = false;

	protected $casts = [
		'booking_id' => 'int'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}
}
