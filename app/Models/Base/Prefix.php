<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prefix
 * 
 * @property int $prefix_id
 * @property string|null $prefix_name
 * @property bool|null $prefix_status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models\Base
 */
class Prefix extends Model
{
	protected $table = 'prefix';
	protected $primaryKey = 'prefix_id';

	protected $casts = [
		'prefix_status' => 'bool'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'prefix');
	}
}
