<?php

namespace App\Models;

use App\Models\Base\BookingRoom as BaseBookingRoom;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingType;

use App\Casts\TimeCast;

class BookingRoom extends BaseBookingRoom
{
	protected $fillable = [
		'booking_id',
		'room_id',
		'no',
		'participant_count',
		'date',
		'time_start',
		'time_end'
	];

    // protected $casts = [
    //     'date' => 'date',
    //     'time_start' => TimeCast::class,
    //     'time_end' => TimeCast::class
    // ];

	public function room()
	{
		return $this->belongsTo(Room::class, 'room_id' , 'room_id');
	}

	public function booking()
	{
		return $this->belongsTo(Booking::class, 'booking_id' , 'booking_id');
	}
	
	public function bookingtype()
	{
		return $this->hasOneThrough(
			BookingType::class,
			Booking::class,
			'booking_id', // Foreign key on Booking table
			'type_id',    // Foreign key on BookingType table
			'booking_id', // Local key on BookingRoom table
			'is_ext'      // Local key on Booking table
		);
	}
// public function bookingtype()
//     {
//         return $this->belongsTo(BookingType::class, 'type_id', 'is_ext');
//     }

}