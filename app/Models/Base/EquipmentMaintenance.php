<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Equipment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentMaintenance
 * 
 * @property int $maintenance_id
 * @property int $equipment_id
 * @property Carbon $start_date
 * @property Carbon|null $end_date
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Equipment $equipment
 *
 * @package App\Models\Base
 */
class EquipmentMaintenance extends Model
{
	protected $table = 'equipment_maintenance';
	protected $primaryKey = 'maintenance_id';

	protected $casts = [
		'equipment_id' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime'
	];

	public function equipment()
	{
		return $this->belongsTo(Equipment::class);
	}
}
