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
 * Class Position
 * 
 * @property int $position_id
 * @property string|null $position_code
 * @property string|null $position_name
 * @property bool|null $status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models\Base
 */
class Position extends Model
{
	protected $table = 'position';
	protected $primaryKey = 'position_id';

	protected $casts = [
		'status' => 'bool'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'position');
	}
}
