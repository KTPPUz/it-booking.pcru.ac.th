<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\StaffUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffType
 * 
 * @property int $staff_type_id
 * @property string|null $name
 * 
 * @property Collection|StaffUser[] $staff_users
 *
 * @package App\Models\Base
 */
class StaffType extends Model
{
	protected $table = 'staff_type';
	protected $primaryKey = 'staff_type_id';
	public $timestamps = false;

	public function staff_users()
	{
		return $this->hasMany(StaffUser::class, 'type_id');
	}
}
