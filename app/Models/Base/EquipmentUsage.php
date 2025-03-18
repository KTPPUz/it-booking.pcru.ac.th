<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Equipment;
use App\Models\EquipmentBorrow;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentUsage
 * 
 * @property int $usage_id
 * @property int $equipment_id
 * @property Carbon $usage_date
 * @property int|null $borrow_id
 * 
 * @property EquipmentBorrow|null $equipment_borrow
 * @property Equipment $equipment
 *
 * @package App\Models\Base
 */
class EquipmentUsage extends Model
{
	protected $table = 'equipment_usage';
	protected $primaryKey = 'usage_id';
	public $timestamps = false;

	protected $casts = [
		'equipment_id' => 'int',
		'usage_date' => 'datetime',
		'borrow_id' => 'int'
	];

	public function equipment_borrow()
	{
		return $this->belongsTo(EquipmentBorrow::class, 'borrow_id');
	}

	public function equipment()
	{
		return $this->belongsTo(Equipment::class);
	}
}
