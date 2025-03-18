<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\AssetLocation;
use App\Models\Booking;
use App\Models\Department;
use App\Models\StaffUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sect
 *
 * @property int $sect_id
 * @property string|null $department_code
 * @property string|null $sect_code
 * @property string|null $sect_name
 * @property bool|null $sect_status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property Department|null $department
 * @property Collection|AssetLocation[] $asset_locations
 * @property Collection|Booking[] $bookings
 * @property Collection|StaffUser[] $staff_users
 * @property Collection|User[] $users
 *
 * @package App\Models\Base
 */
class Sect extends Model
{
	protected $table = 'sect';
	protected $primaryKey = 'sect_id';

	protected $casts = [
		'sect_status' => 'int'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'department_code', 'department_code');
	}

	public function asset_locations()
	{
		return $this->hasMany(AssetLocation::class);
	}

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	public function staff_users()
	{
		return $this->hasMany(StaffUser::class);
	}

	public function users()
	{
		return $this->hasMany(User::class, 'sect');
	}
}
