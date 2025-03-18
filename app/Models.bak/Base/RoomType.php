<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomType
 *
 * @property int $type_id
 * @property string|null $name
 * @property bool|null $status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property Collection|Room[] $rooms
 *
 * @package App\Models\Base
 */
class RoomType extends Model
{
	protected $table = 'room_type';
	protected $primaryKey = 'type_id';

	protected $casts = [
		'status' => 'int'
	];

	public function rooms()
	{
		return $this->hasMany(Room::class, 'room_type');
	}
}
