<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;


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
class StaffType extends Model
{
    protected $table = 'staff_type';
	protected $primaryKey = 'staff_type_id';


	protected $casts = [
		'name' => 'string',
	];

}