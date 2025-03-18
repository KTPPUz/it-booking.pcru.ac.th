<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentStatus
 * 
 * @property int $status_id
 * @property string $name
 *
 * @package App\Models\Base
 */
class EquipmentStatus extends Model
{
	protected $table = 'equipment_status';
	protected $primaryKey = 'status_id';
	public $timestamps = false;
}
