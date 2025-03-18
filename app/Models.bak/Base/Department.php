<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\AssetLocation;
use App\Models\Booking;
use App\Models\Sect;
use App\Models\StaffUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 *
 * @property int $department_id
 * @property string|null $department_code
 * @property string|null $department_name
 * @property bool|null $department_status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property Collection|AssetLocation[] $asset_locations
 * @property Collection|Booking[] $bookings
 * @property Collection|Sect[] $sects
 * @property Collection|StaffUser[] $staff_users
 * @property Collection|User[] $users
 *
 * @package App\Models\Base
 */
class Department extends Model
{
	protected $table = 'department';
	protected $primaryKey = 'department_id';

	protected $casts = [
		'department_status' => 'int'
	];

	public function asset_locations()
	{
		return $this->hasMany(AssetLocation::class);
	}

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	public function sects()
	{
		return $this->hasMany(Sect::class, 'department_code', 'department_code');
	}

	public function staff_users()
	{
		return $this->hasMany(StaffUser::class);
	}

	public function users()
	{
		return $this->hasMany(User::class, 'department');
	}
}
