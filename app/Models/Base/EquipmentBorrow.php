<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Department;
use App\Models\EquipmentBorrowDetail;
use App\Models\EquipmentBorrowReturn;
use App\Models\EquipmentUsage;
use App\Models\Sect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentBorrow
 * 
 * @property int $borrow_id
 * @property string $borrower_name
 * @property Carbon $borrow_date
 * @property Carbon|null $expect_return_date
 * @property string $status
 * @property int|null $sect_id
 * @property int|null $dept_id
 * @property string $staff_user
 * @property Carbon|null $created_at
 * 
 * @property Department|null $department
 * @property Sect|null $sect
 * @property Collection|EquipmentBorrowDetail[] $equipment_borrow_details
 * @property Collection|EquipmentBorrowReturn[] $equipment_borrow_returns
 * @property Collection|EquipmentUsage[] $equipment_usages
 *
 * @package App\Models\Base
 */
class EquipmentBorrow extends Model
{
	protected $table = 'equipment_borrow';
	protected $primaryKey = 'borrow_id';
	public $timestamps = false;

	protected $casts = [
		'borrow_date' => 'datetime',
		'expect_return_date' => 'datetime',
		'sect_id' => 'int',
		'dept_id' => 'int'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'dept_id');
	}

	public function sect()
	{
		return $this->belongsTo(Sect::class);
	}

	public function equipment_borrow_details()
	{
		return $this->hasMany(EquipmentBorrowDetail::class, 'borrow_id');
	}

	public function equipment_borrow_returns()
	{
		return $this->hasMany(EquipmentBorrowReturn::class, 'borrow_id');
	}

	public function equipment_usages()
	{
		return $this->hasMany(EquipmentUsage::class, 'borrow_id');
	}
}
