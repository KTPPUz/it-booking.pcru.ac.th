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
 * Class EquipmentBorrowReturn
 * 
 * @property int $return_id
 * @property int $borrow_id
 * @property int $equipment_id
 * @property Carbon $return_date
 * @property string $return_condition
 * 
 * @property EquipmentBorrow $equipment_borrow
 * @property Equipment $equipment
 *
 * @package App\Models\Base
 */
class EquipmentBorrowReturn extends Model
{
	protected $table = 'equipment_borrow_return';
	protected $primaryKey = 'return_id';
	public $timestamps = false;

	protected $casts = [
		'borrow_id' => 'int',
		'equipment_id' => 'int',
		'return_date' => 'datetime'
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
