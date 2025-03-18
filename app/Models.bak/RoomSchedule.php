<?php

namespace App\Models;

use App\Models\Base\RoomSchedule as BaseRoomSchedule;
use Carbon\Carbon;

class RoomSchedule extends BaseRoomSchedule
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_CANCEL_TRAINING = 3;

    const CALENDAR_STATUS_UNSYNCED = 0;
    const CALENDAR_STATUS_SYNCED = 1;
    const CALENDAR_STATUS_DELETED = 2;


    protected $fillable = [
        'booking_id',
        'room_id',
        'dt_start',
        'dt_end',
        'status',
        'calendar_event_id',
        'calendar_status'
    ];

    static public function generateRoomSchedule($rooms): array
    {
        $roomSchedules = [];
        foreach ($rooms as $room) {
            $roomSchedule = new RoomSchedule();
            $roomSchedule->booking_id = $room->pivot->booking_id;
            $roomSchedule->room_id = $room->pivot->room_id;
            $roomSchedule->dt_start = Carbon::parse($room->pivot->date . ' ' . $room->pivot->time_start)->format('Y-m-d H:i:s');
            $roomSchedule->dt_end = Carbon::parse($room->pivot->date . ' ' . $room->pivot->time_end)->format('Y-m-d H:i:s');
            $roomSchedule->status = self::STATUS_ACTIVE;
            $roomSchedules[] = $roomSchedule;
        }

        // Convert RoomSchedule instances to an array for bulk insert
        $roomSchedulesArray = array_map(function ($roomSchedule) {
            return [
                'booking_id' => $roomSchedule->booking_id,
                'room_id' => $roomSchedule->room_id,
                'dt_start' => $roomSchedule->dt_start,
                'dt_end' => $roomSchedule->dt_end,
                'status' => $roomSchedule->status,
            ];
        }, $roomSchedules);

        // Insert into database
        self::insert($roomSchedulesArray);

        return $roomSchedules;
    }

    static public function cancelRoomSchedule($roomSchedules): array
    {
        if ($roomSchedules->isEmpty()) {
            return [];
        }

        foreach ($roomSchedules as $roomSchedule) {
            $roomSchedule->status = self::STATUS_CANCELLED;
            $roomSchedule->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        }

        $roomSchedulesArray = $roomSchedules->map(function ($roomSchedule) {
            return array_merge($roomSchedule->toArray(), [
                'created_at' => Carbon::parse($roomSchedule->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($roomSchedule->updated_at)->format('Y-m-d H:i:s'),
                'dt_start' => Carbon::parse($roomSchedule->dt_start)->format('Y-m-d H:i:s'),
                'dt_end' => Carbon::parse($roomSchedule->dt_end)->format('Y-m-d H:i:s'),
            ]);
        })->toArray();

        self::upsert($roomSchedulesArray, ['id'], ['status', 'updated_at']);

        return $roomSchedulesArray;
    }


    //  static public function cancelRoomSchedule($roomSchedules): array
    // {
    //     foreach ($roomSchedules as $roomSchedule) {
    //         $roomSchedule->status = self::STATUS_CANCELLED;
    //     }
    //     self::upsert($roomSchedules, ['id'], ['status']);
    //     return $roomSchedules;
    // }


    public function room()
	{
		return $this->belongsTo(Room::class, 'room_id' , 'room_id');
	}

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id' , 'is_classroom');
    }

    public function sect(){
        return $this->belongsTo(Sect::class, 'sect_id');
    }
}