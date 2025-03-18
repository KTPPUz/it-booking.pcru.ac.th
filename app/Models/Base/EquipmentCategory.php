<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\EquipmentGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentCategory
 * 
 * @property int $category_id
 * @property string $name
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|EquipmentGroup[] $equipment_groups
 *
 * @package App\Models\Base
 */
class EquipmentCategory extends Model
{
	protected $table = 'equipment_category';
	protected $primaryKey = 'category_id';

	protected $casts = [
		'status' => 'int'
	];

	public function equipment_groups()
	{
		return $this->hasMany(EquipmentGroup::class, 'category_id');
	}
}
