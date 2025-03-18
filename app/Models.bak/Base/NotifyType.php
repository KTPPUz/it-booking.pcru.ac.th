<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Notify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotifyType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $target
 * @property string|null $key
 * @property bool|null $status
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property Collection|Notify[] $notifies
 *
 * @package App\Models\Base
 */
class NotifyType extends Model
{
	protected $table = 'notify_type';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'status' => 'int'
	];

	public function notifies()
	{
		return $this->hasMany(Notify::class, 'notify_type');
	}
}
