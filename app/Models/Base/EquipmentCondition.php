<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentCondition
 * 
 * @property int $condition_id
 * @property string $name
 *
 * @package App\Models\Base
 */
class EquipmentCondition extends Model
{
	protected $table = 'equipment_condition';
	protected $primaryKey = 'condition_id';
	public $timestamps = false;
}
