<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Department;
use App\Models\Sect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffUser
 * 
 * @property int $staff_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $department_id
 * @property int|null $sect_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Department|null $department
 * @property Sect|null $sect
 *
 * @package App\Models\Base
 */
class StaffUser extends Model
{
	protected $table = 'staff_users';
	protected $primaryKey = 'staff_id';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'department_id' => 'int',
		'sect_id' => 'int',
		'type_id' => 'int'
	];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function sect()
	{
		return $this->belongsTo(Sect::class);
	}
}