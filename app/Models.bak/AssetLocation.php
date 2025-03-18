<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Base\AssetLocation as BaseAssetLocation;

class AssetLocation extends BaseAssetLocation
{
	use HasFactory;

    protected $fillable = [
        'asset_id',
        'room_id',
        'department_id',
        'sect_id',
        'location_type',
        'is_current',
        'moved_at',
    ];

	public function asset()
	{
		return $this->belongsTo(Asset::class , 'asset_id');
	}

	public function room()
	{
		return $this->belongsTo(Room::class , 'room_id');
	}

	public function department()
	{
		return $this->belongsTo(Department::class , 'department_id');
	}

	public function sect()
	{
		return $this->belongsTo(Sect::class , 'sect_id');
	}
	


}