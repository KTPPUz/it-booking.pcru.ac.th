<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserBooking extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;


    protected $table = 'user_booking';
	// protected $primaryKey = 'user_id';
	
	protected $fillable = [
		'user_id',
		'room_id',
		'status',
		'ubooking_date',
		'ubooking_timestart',
		'ubooking_timeend',
		'participant_count',
		'no'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function room()
	{
		return $this->belongsTo(Room::class, 'room_id', 'room_id');
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