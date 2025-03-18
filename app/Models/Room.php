<?php

namespace App\Models;

use App\Models\Base\Room as BaseRoom;

class Room extends BaseRoom
{


    protected $fillable = [
        'room_type',
        'room_name',
        'capacity',
        'room_pic',
        'description',
        'status'
    ];


	public function roomtype()
	{
		return $this->belongsTo(RoomType::class, 'room_type' , 'type_id');
	}

  	public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function sect()
    {
        return $this->belongsTo(Sect::class, 'sect_id', 'sect_id');
    }

    public function bookingrooms()
    {
        return $this->hasMany(BookingRoom::class, 'room_id', 'room_id');
    }

    public function roomschedules()
    {
        return $this->hasMany(RoomSchedule::class, 'room_id', 'room_id');
    }
}