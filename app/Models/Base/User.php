<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Booking;
use App\Models\Department;
use App\Models\Notify;
use App\Models\Position;
use App\Models\Prefix;
use App\Models\Sect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string|null $emp_code
 * @property int|null $prefix
 * @property int|null $position
 * @property string $name
 * @property string|null $mobile_number
 * @property string|null $internal_number
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $department
 * @property int|null $sect
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Booking[] $bookings
 * @property Collection|Notify[] $notifies
 *
 * @package App\Models\Base
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'prefix' => 'int',
		'position' => 'int',
		'email_verified_at' => 'datetime',
		'department' => 'int',
		'sect' => 'int'
	];

	public function prefix()
	{
		return $this->belongsTo(Prefix::class, 'prefix');
	}

	public function position()
	{
		return $this->belongsTo(Position::class, 'position');
	}

	public function department()
	{
		return $this->belongsTo(Department::class, 'department');
	}

	public function sect()
	{
		return $this->belongsTo(Sect::class, 'sect');
	}

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	public function notifies()
	{
		return $this->hasMany(Notify::class);
	}
}
