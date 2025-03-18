<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingType
 * 
 * @property int $type_id
 * @property string|null $name
 * @property int|null $status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models\Base
 */
class BookingType extends Model
{
	protected $table = 'booking_type';
	protected $primaryKey = 'type_id';

	protected $casts = [
		'status' => 'int'
	];
}
