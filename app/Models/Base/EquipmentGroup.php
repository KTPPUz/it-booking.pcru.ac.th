<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\EquipmentCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentGroup
 * 
 * @property int $group_id
 * @property int $category_id
 * @property string $code
 * @property string|null $name
 * @property string|null $budget_source
 * @property Carbon $acquisition_year
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property EquipmentCategory $equipment_category
 *
 * @package App\Models\Base
 */
class EquipmentGroup extends Model
{
	protected $table = 'equipment_group';
	protected $primaryKey = 'group_id';

	protected $casts = [
		'category_id' => 'int',
		'acquisition_year' => 'datetime',
		'status' => 'int'
	];

	public function equipment_category()
	{
		return $this->belongsTo(EquipmentCategory::class, 'category_id');
	}
}
