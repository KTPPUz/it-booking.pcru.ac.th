<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Booking as BaseBooking;
use App\Models\ModelConst as Consts;
use App\Models\Base\Department;
// use App\Models\Sect;
use App\Models\ModelConst;

class Booking extends BaseBooking
{

    protected $fillable = [
        'user_id',
        'department_id',
        'sect_id',
        'reason',
        'is_ext',
        'is_classroom',
        'sent_dt',
        'reviewer_id',
        'review_status',
        'review_dt',
        'review_comment',
        'cancel_reason',
        'canceled_at',
        'doc_status',
        'doc_state',
        'step_status',
        'room_id',
    ];

    public static function getAttributeOptions($attribute)
    {
        return ModelConst::getAttributeOptions($attribute);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function sect()
    {
        return $this->belongsTo(Sect::class, 'sect_id', 'sect_id');
    }

    	
	public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class, 'booking_id');
    }
    
    public function roomSchedules()
    {
        return $this->hasMany(RoomSchedule::class, 'booking_id'); 
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_room', 'booking_id', 'room_id')
                    ->withPivot('no', 'participant_count', 'date', 'time_start', 'time_end');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    


    
    public const REVIEW_STATUS_PENDING = 0;
    public const REVIEW_STATUS_APPROVED = 1;
    public const REVIEW_STATUS_REJECTED = 2;

    public const STATUS_DRAFT = 0;
    public const STATUS_PENDING = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_REJECTED = 3;
    public const STATUS_CANCELLED = 4;

    public const attributeOptions = [
        'review_status' => [
            'label' => [
                self::REVIEW_STATUS_PENDING => 'รออนุมัติ',
                self::REVIEW_STATUS_APPROVED => 'อนุมัติ',
                self::REVIEW_STATUS_REJECTED => 'ไม่อนุมัติ'
            ],
            'color' => [
                self::REVIEW_STATUS_PENDING => 'warning',
                self::REVIEW_STATUS_APPROVED => 'success',
                self::REVIEW_STATUS_REJECTED => 'danger'
            ],
            'class' => [
                self::REVIEW_STATUS_PENDING => 'badge bg-warning',
                self::REVIEW_STATUS_APPROVED => 'badge bg-success',
                self::REVIEW_STATUS_REJECTED => 'badge bg-danger'
            ],
            'icon' => [
                self::REVIEW_STATUS_PENDING => 'fa fa-clock',
                self::REVIEW_STATUS_APPROVED => 'fa fa-check',
                self::REVIEW_STATUS_REJECTED => 'fa fa-times'
            ]
        ],
        'doc_status' => [
            'label' => [
                self::STATUS_DRAFT => 'ร่าง',
                self::STATUS_PENDING => 'รออนุมัติ',
                self::STATUS_APPROVED => 'อนุมัติ',
                self::STATUS_REJECTED => 'ไม่อนุมัติ',
                self::STATUS_CANCELLED => 'ยกเลิก'
            ],
            'color' => [
                self::STATUS_DRAFT => 'secondary',
                self::STATUS_PENDING => 'warning',
                self::STATUS_APPROVED => 'success',
                self::STATUS_REJECTED => 'danger',
                self::STATUS_CANCELLED => 'danger'
            ],
            'class' => [
                self::STATUS_DRAFT => 'badge bg-secondary',
                self::STATUS_PENDING => 'badge bg-warning',
                self::STATUS_APPROVED => 'badge bg-success',
                self::STATUS_REJECTED => 'badge bg-danger',
                self::STATUS_CANCELLED => 'badge bg-danger'
            ],
            'icon' => [
                self::STATUS_DRAFT => 'fa fa-file',
                self::STATUS_PENDING => 'fa fa-clock',
                self::STATUS_APPROVED => 'fa fa-check',
                self::STATUS_REJECTED => 'fa fa-times',
                self::STATUS_CANCELLED => 'fa fa-times'
            ]
        ]
    ];

    static public function getArrtibuteOptions($attribute)
    {
        return self::attributeOptions[$attribute] ?? [];
    }
    // static public function getArrtibuteOptions($attribute)
    // {
    //     switch ($attribute) {
    //         case 'review_status':
    //             return [
    //                 self::attributeOptions['review_status'],
    //             ];
    //         case 'doc_status':
    //             return [
    //                 self::attributeOptions['doc_status'],
    //             ];
    //         default:
    //             return [];
    //     }
    // }


    public function revieww($status, $save = true)
    {
        if ($status == self::REVIEW_STATUS_APPROVED) {
            return $this->approve($save);
        } elseif ($status == self::REVIEW_STATUS_REJECTED) {
            return $this->reject($save);
        }

        return $this;
    }

    public function send($save = true)
    {
        $this->sent_dt = now();
        return $this->updateStatus(self::STATUS_PENDING, Consts::STATE_PROCESSING, $save);
    }

    public function unsent($save = true)
    {
        $this->sent_dt = null;
        return $this->updateStatus(self::STATUS_DRAFT, Consts::STATE_WAITING, $save);
    }


    public function approve($save = true)
    {
        $this->reviewer_id = auth()->guard('staff')->id();
        $this->review_dt = now();
        $this->review_status = self::REVIEW_STATUS_APPROVED;

        return $this->updateStatus(self::STATUS_APPROVED, Consts::STATE_COMPLETED, $save);
    }

    public function reject($save = true)
    {
        $this->reviewer_id = auth()->guard('staff')->id();
        $this->review_dt = now();
        $this->review_status = self::REVIEW_STATUS_REJECTED;

        return $this->updateStatus(self::STATUS_REJECTED, Consts::STATE_COMPLETED, $save);
    }

    public function cancel($reason, $save = true)
    {
        $this->cancel_reason = $reason;
        $this->canceled_at = now();
        return $this->updateStatus(self::STATUS_CANCELLED, Consts::STATE_COMPLETED, $save);
    }

    private function updateStatus($status, $state, $save)
    {
        $this->doc_status = $status;
        $this->doc_state = $state;
        if ($save) {
            $this->save();
        }
        return $this;
    }

  
}