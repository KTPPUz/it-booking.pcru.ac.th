<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\EquipmentBorrowDetail;
use App\Models\EquipmentBorrowReturn;
use App\Models\EquipmentLocation;
use App\Models\EquipmentMaintenance;
use App\Models\EquipmentUsage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipment
 * 
 * @property int $equipment_id
 * @property string $equipment_code
 * @property string $name
 * @property string $status
 * @property string $condition
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * 
 * @property Collection|EquipmentBorrowDetail[] $equipment_borrow_details
 * @property Collection|EquipmentBorrowReturn[] $equipment_borrow_returns
 * @property Collection|EquipmentLocation[] $equipment_locations
 * @property Collection|EquipmentMaintenance[] $equipment_maintenances
 * @property Collection|EquipmentUsage[] $equipment_usages
 *
 * @package App\Models\Base
 */
class Equipment extends Model
{
	protected $table = 'equipment';
	protected $primaryKey = 'equipment_id';

	public function equipment_borrow_details()
	{
		return $this->hasMany(EquipmentBorrowDetail::class);
	}

	public function equipment_borrow_returns()
	{
		return $this->hasMany(EquipmentBorrowReturn::class);
	}

	public function equipment_locations()
	{
		return $this->hasMany(EquipmentLocation::class);
	}

	public function equipment_maintenances()
	{
		return $this->hasMany(EquipmentMaintenance::class);
	}

	public function equipment_usages()
	{
		return $this->hasMany(EquipmentUsage::class);
	}
}
