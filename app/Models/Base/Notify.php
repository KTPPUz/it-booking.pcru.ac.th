<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\NotifyType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notify
 * 
 * @property int $user_id
 * @property int $notify_no
 * @property int|null $notify_type
 * @property string|null $notify_uid
 * @property bool $notify_status
 * @property bool $is_staff
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property User $user
 *
 * @package App\Models\Base
 */
class Notify extends Model
{
	protected $table = 'notify';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int',
		'notify_no' => 'int',
		'notify_type' => 'int',
		'notify_status' => 'bool',
		'is_staff' => 'bool'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function notify_type()
	{
		return $this->belongsTo(NotifyType::class, 'notify_type');
	}
}
