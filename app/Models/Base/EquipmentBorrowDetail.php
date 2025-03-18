<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Equipment;
use App\Models\EquipmentBorrow;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentBorrowDetail
 * 
 * @property int $detail_id
 * @property int $borrow_id
 * @property int $equipment_id
 * @property string $status
 * 
 * @property EquipmentBorrow $equipment_borrow
 * @property Equipment $equipment
 *
 * @package App\Models\Base
 */
class EquipmentBorrowDetail extends Model
{
	protected $table = 'equipment_borrow_detail';
	protected $primaryKey = 'detail_id';
	public $timestamps = false;

	protected $casts = [
		'borrow_id' => 'int',
		'equipment_id' => 'int'
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
