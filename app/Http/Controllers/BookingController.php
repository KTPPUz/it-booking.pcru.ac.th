<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StorebookingRequest;
use App\Http\Requests\UpdatebookingRequest;


use App\Models\Booking;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RoomSchedule;
use App\Models\BookingRoom;
use App\Models\Sect;
use App\Models\Department;
use App\Models\ModelConst;
use App\Models\User;
use App\Models\BookingType;

use App\Mail\NotifyApproval;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Mail\BookingReviewed;
use App\Mail\BookingSend;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'department', 'sect'])
            ->where('user_id', auth()->user()->id)
            ->where('doc_status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $room = Room::all();
        $bookingrooms = BookingRoom::all();

        $attrConfig = Booking::getAttributeOptions('state');
        $attrConfigdoc = Booking::getArrtibuteOptions('doc_status');


      

        return view('booking.index', compact('bookings', 'room', 'attrConfig' , 'attrConfigdoc' , 'bookingrooms' ));
    }

     public function indexuser(){
        $bookings = Booking::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $bookingrooms = BookingRoom::all();

        $attrConfig = Booking::getAttributeOptions('state');
        $attrConfigdoc = Booking::getArrtibuteOptions('doc_status');

        return view('booking.bookingalluser', compact('bookings' , 'attrConfig' , 'attrConfigdoc' , 'bookingrooms'));
    }


    // public function indexuser(){
    //     $bookings = Booking::where('user_id', auth()->user()->id)
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    //     $bookingrooms = BookingRoom::all();

    //     $attrConfig = Booking::getAttributeOptions('state');
    //     $attrConfigdoc = Booking::getAttributeOptions('doc_status');

    //     return view('booking.bookingalluser', compact('bookings', 'attrConfig', 'attrConfigdoc', 'bookingrooms'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $booking = Booking::all();
        $bookings = new Booking();

        $user = auth()->user();
        $bookings->user_id = $user->id;

        if ($bookings->save()) {
            return redirect()->route('booking.edit', ['id' => $bookings->booking_id]);
        }
        // return view('booking.create');
        return redirect()->route('bookings');

    }


      /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'user_id' => auth()->id(),
            // 'is_classroom' => $request->has('is_classroom') ? 1 : 0,
            // 'is_ext' => $request->has('is_ext') ? 1 : 0,
            // 'is_ext' => $request->department_id == 19 ? 1 : 0,
            'reason' => $request->reason,
            'sect_id' => $request->sect_id,
            'department_id' => $request->department_id,
            'is_ext' => $request->type_id,


        ]);

        return redirect()->route('booking.edit', ['id' => $booking->booking_id])->with('success', 'Booking updated successfully.');
    }

    
    // public function newbooking($id = null )
    public function newbooking($room_id = null ,  $id = null)
    {
        // dd($room_id, Room::find($room_id));
        
        // $rooms = Room::all();
        $rooms = Room::all();
        $selectedRoom = Room::find($room_id);
        if (!$selectedRoom) {
            $selectedRoom = null;
        }
        $roomtypes = RoomType::all();
        $sects = Sect::all();
        $departments = Department::all();
        $bookingtype = BookingType::all();
        $booking = $id ? Booking::findOrFail($id) : null;

        return view('booking.newbooking', compact('rooms', 'roomtypes', 'sects', 'departments' , 'bookingtype' , 'booking'  , 'selectedRoom'));
    }

     public function newbookingc(Request $request, $id = null)
    {
        // dd($room_id, Room::find($room_id));
        $startDate = $request->query('start');
        // $rooms = Room::all();
        $rooms = Room::where('status', '!=', '1')->get();
        // $selectedRoom = Room::find($room_id);
        // if (!$selectedRoom) {
        //     $selectedRoom = null;
        // }
        $roomtypes = RoomType::all();
        $sects = Sect::all();
        $departments = Department::all();
        $bookingtype = BookingType::all();
        $booking = $id ? Booking::findOrFail($id) : null;

        return view('booking.newbookingc', compact('rooms', 'roomtypes', 'sects', 'departments' , 'bookingtype' , 'booking' , 'startDate'));
    }
      /**
     * Update the specified resource in storage.
     */

    public function newupdate(Request $request) {
        DB::beginTransaction(); 
        try {
            $overlappingBookings = BookingRoom::where('room_id', $request->room_id)
                ->where('date', $request->date)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('time_start', [$request->time_start, $request->time_end])
                        ->orWhereBetween('time_end', [$request->time_start, $request->time_end])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('time_start', '<=', $request->time_start)
                                ->where('time_end', '>=', $request->time_end);
                        });
                })
                ->whereHas('booking', function ($query) use ($request) {
                    if ($request->type_id == 1) {
                        $query->where('is_ext', '!=', 3);
                    }
                    $query->where('doc_status', '!=', 4);
                })
                ->exists();
                
            if ($overlappingBookings) {
                return redirect()->route('br.newbooking')->with('error', 'มีการจองห้องในช่วงเวลานี้แล้ว');
            }

            $booking = new Booking();
            $booking->user_id = auth()->id();
            $booking->department_id = $request->department_id;
            $booking->sect_id = $request->sect_id;
            $booking->is_ext = $request->type_id;
            $booking->sent_dt = now();

            if ($booking->is_ext == Booking::CALENDAR_SHOW) {
                $booking->training_id = 1;

                Booking::whereHas('bookingRooms', function ($query) use ($request) {
                    $query->where('room_id', $request->room_id)
                          ->where('date', $request->date);
                })->where('is_ext', 3)
                  ->update(['training_id' => Booking::CALENDAR_HIGH]);
            } else if ($booking->is_ext == 3) {
                $booking->training_id = Booking::CALENDAR_HIGH;
            }
            
            $booking->send();

            Mail::to('st641102064110@pcru.ac.th')
                ->send(new BookingSend($booking));
            
            $booking->save();

            $lastBookingRoom = BookingRoom::where('booking_id', $booking->booking_id)
                ->orderBy('no', 'desc')
                ->first();
            $bookingroom = new BookingRoom();
            $bookingroom->booking_id = $booking->booking_id;
            $bookingroom->room_id = $request->room_id;
            $bookingroom->no = $lastBookingRoom ? $lastBookingRoom->no + 1 : 1;
            $bookingroom->date = $request->date;
            $bookingroom->time_start = $request->time_start;
            $bookingroom->time_end = $request->time_end;
            $bookingroom->participant_count = $request->participant_count;
            $bookingroom->save();
            
            DB::commit();
            return redirect()->route('bookings')->with('success', 'การจองห้องถูกสร้างเรียบร้อยแล้ว!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('rooms.show')->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }


    // public function newupdate(Request $request) {
    //     DB::beginTransaction(); 
    //     try {
    //         $overlappingBookings = BookingRoom::where('room_id', $request->room_id)
    //             ->where('date', $request->date)
    //             ->where(function ($query) use ($request) {
    //                 $query->whereBetween('time_start', [$request->time_start, $request->time_end])
    //                     ->orWhereBetween('time_end', [$request->time_start, $request->time_end])
    //                     ->orWhere(function ($query) use ($request) {
    //                         $query->where('time_start', '<=', $request->time_start)
    //                             ->where('time_end', '>=', $request->time_end);
    //                     });
    //             })

    //             ->whereHas('booking', function ($query) use ($request) {
    //                 if ($request->type_id == 1) {
    //                     $query->where('is_ext', '!=', 3);
    //                 }
    //             })
    //             ->exists();
                
    //         if ($overlappingBookings) {
    //             return redirect()->route('br.newbooking')->with('error', 'มีการจองห้องในช่วงเวลานี้แล้ว');
    //         }

    //         $booking = new Booking();
    //         $booking->user_id = auth()->id();
    //         $booking->department_id = $request->department_id;
    //         $booking->sect_id = $request->sect_id;
    //         $booking->is_ext = $request->type_id;
    //         $booking->sent_dt = now();

    //           if ($booking->is_ext != 3) {
    //             $booking->training_id = 2;
    //         }
            
    //         $booking->send();

    //         Mail::to('st641102064110@pcru.ac.th')
    //             ->send(new BookingSend($booking));
            
    //         $booking->save();

    //         $lastBookingRoom = BookingRoom::where('booking_id', $booking->booking_id)
    //             ->orderBy('no', 'desc')
    //             ->first();
    //         $bookingroom = new BookingRoom();
    //         $bookingroom->booking_id = $booking->booking_id;
    //         $bookingroom->room_id = $request->room_id;
    //         $bookingroom->no = $lastBookingRoom ? $lastBookingRoom->no + 1 : 1;
    //         $bookingroom->date = $request->date;
    //         $bookingroom->time_start = $request->time_start;
    //         $bookingroom->time_end = $request->time_end;
    //         $bookingroom->participant_count = $request->participant_count;
    //         $bookingroom->save();
            
    //         DB::commit();
    //         return redirect()->route('bookings')->with('success', 'การจองห้องถูกสร้างเรียบร้อยแล้ว!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('rooms.show')->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
    //     }
    // }


    
    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $booking = Booking::with(['rooms'])->findOrFail($id);
        $rooms = Room::all();
        $roomtypes = RoomType::all();
        $sects = Sect::all();
        $departments = Department::all();
        $bookingtype = BookingType::all();

        return view('booking.edit', compact('booking', 'rooms', 'roomtypes', 'sects', 'departments' , 'bookingtype'));
    }

  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        BookingRoom::where('booking_id', $id)->delete();
        $booking->delete();

        return redirect()->route('bookings')->with('success', 'Booking deleted successfully.');
    }

    public function send(Request $request)
    {
        $booking = Booking::with('rooms')->findOrFail($request->id);
        // $bookingroom = BookingRoom::where('booking_id', $request->id)->get();

        $booking->send();

        Mail::to('st641102064110@pcru.ac.th')
            ->send(new BookingSend($booking));
            
        return redirect()->route('bookings')->with('success', 'Booking sent successfully.');
    }

    public function unsent(Request $request)
    {
        $booking = Booking::findOrFail($request->id);
        $booking->unsent();

      

        return redirect()->route('bookings')->with('success', 'Booking unsent successfully.');
    }
    

    public function review(Request $request, $id)
{
    $booking = Booking::with('rooms', 'user')->findOrFail($id);
    $bookingroom = BookingRoom::where('booking_id', $id)->get();

    $booking->review_comment = $request->review_comment;
    $booking->review_status = $request->review_status;
    $booking->revieww($request->review_status);
    $booking->save();

    // อัปเดตตาราง RoomSchedule
    RoomSchedule::generateRoomSchedule($booking->rooms);

    // ส่งอีเมลแจ้งเตือนหากมีอีเมลของผู้ใช้
    if ($booking->user && !empty($booking->user->email)) {
        Mail::to($booking->user->email)->send(new BookingReviewed($booking, $bookingroom));
    }

    // ดึงรายการ `room_schedule` ที่ยังไม่มี `calendar_event_id`
    $schedules = RoomSchedule::whereNull('calendar_event_id')->get();
    $count = 0;

    foreach ($schedules as $schedule) {
        try {
            // ดึง `participant_count` จาก booking_room โดยใช้ `booking_id` และช่วงเวลาเดียวกัน
            $participant_count = BookingRoom::where('booking_id', $schedule->booking_id)
                ->where('room_id', $schedule->room_id)
                ->whereDate('date', '=', Carbon::parse($schedule->dt_start)->toDateString()) // ตรวจสอบวันที่เดียวกัน
                ->value('participant_count');

            // ถ้าไม่มีข้อมูล ให้กำหนดค่าเริ่มต้นเป็น 0
            $participant_count = $participant_count ?? 0;

            $username = $booking->user->name;

            $bookingtype = BookingType::where('type_id', $booking->is_ext)->first();

            // สร้าง Event ใหม่ใน Google Calendar
            $event = new Event;
            $event->name =  $schedule->room->room_name . " $username "  . " จำนวน " . $participant_count . " คน";
            $event->startDateTime = Carbon::parse($schedule->dt_start);
            $event->endDateTime = Carbon::parse($schedule->dt_end);
            $event->description = "รหัสการจอง: " . $schedule->booking_id . " | ห้อง: " . $schedule->room->room_name . " | จองสำหรับ:  $bookingtype->name
            
            ";
            $event->location = "Phetchabun Rajabhat University";

            $savedEvent = $event->save();

            $schedule->update([
                'calendar_event_id' => $savedEvent->id,
                'calendar_status' => 1, // อัปเดตสถานะว่าส่งสำเร็จ
            ]);

            $count++;
        } catch (\Exception $e) {
            \Log::error("Google Calendar Error: " . $e->getMessage());
        }
    }

    // ส่ง response กลับไปให้ frontend
    return redirect()->route('review.index')
        ->with('success', "อนุมัติและส่งอีเมล์แจ้งเตือนเรียบร้อยแล้ว | เพิ่ม {$count} รายการลง Google Calendar สำเร็จ");
}

    // public function review(Request $request, $id)
    // {
    //     // ดึงข้อมูลการจอง พร้อมความสัมพันธ์
    //     $booking = Booking::with('rooms', 'user')->findOrFail($id);
    //     $bookingroom = BookingRoom::where('booking_id', $id)->get();

    //     // อัปเดตสถานะการตรวจสอบ
    //     $booking->review_comment = $request->review_comment;
    //     $booking->review_status = $request->review_status;
    //     $booking->revieww($request->review_status);
    //     $booking->save();

    //     // อัปเดตตาราง RoomSchedule
    //     RoomSchedule::generateRoomSchedule($booking->rooms);

    //     // ส่งอีเมลแจ้งเตือนหากมีอีเมลของผู้ใช้
    //     if ($booking->user && !empty($booking->user->email)) {
    //         Mail::to($booking->user->email)->send(new BookingReviewed($booking, $bookingroom));
    //     }

    //     // ดึงรายการ `room_schedule` ที่ยังไม่มี `calendar_event_id`
    //     $schedules = RoomSchedule::whereNull('calendar_event_id')->get();
    //     $count = 0;

    //     foreach ($schedules as $schedule) {
    //         try {
    //             // สร้าง Event ใหม่ใน Google Calendar
    //             $event = new Event;
    //             $event->name =  $schedule->room->room_name . "อ.โบ"  . " จำนวน " . $schedule->participant_count . " คน";
    //             $event->startDateTime = Carbon::parse($schedule->dt_start);
    //             $event->endDateTime = Carbon::parse($schedule->dt_end);
    //             $event->description = "รหัสการจอง: " . $schedule->booking_id . " | ห้อง: " . $schedule->room->room_name;
    //             $event->location = "Phetchabun Rajabhat University";

    //             // บันทึกลง Google Calendar
    //             $savedEvent = $event->save();

    //             // อัปเดต `room_schedule`
    //             $schedule->update([
    //                 'calendar_event_id' => $savedEvent->id,
    //                 'calendar_status' => 1, // อัปเดตสถานะว่าส่งสำเร็จ
    //             ]);

    //             $count++;
    //         } catch (\Exception $e) {
    //             \Log::error("Google Calendar Error: " . $e->getMessage());
    //         }
    //     }

    //     // ส่ง response กลับไปให้ frontend
    //     return redirect()->route('review.index')
    //         ->with('success', "อนุมัติและส่งอีเมล์แจ้งเตือนเรียบร้อยแล้ว | เพิ่ม {$count} รายการลง Google Calendar สำเร็จ");
    // }

    
    // public function syncRoomScheduleToGoogleCalendar()
    // {
    //     // ดึงข้อมูลจากตาราง room_schedule ที่ยังไม่มี calendar_event_id
    //     $schedules = DB::table('room_schedule')
    //         ->whereNull('calendar_event_id') // ดึงเฉพาะที่ยังไม่มี Event ใน Calendar
    //         ->get();

    //     foreach ($schedules as $schedule) {
    //         // สร้าง Event ใหม่ใน Google Calendar
    //         $event = new Event;
    //         $event->name = "จองห้องประชุม #" . $schedule->room_id;
    //         $event->startDateTime = Carbon::parse($schedule->dt_start);
    //         $event->endDateTime = Carbon::parse($schedule->dt_end);
    //         $event->description = "Booking ID: " . $schedule->booking_id;
    //         $event->location = "Phetchabun Rajabhat University";

    //         // บันทึกอีเวนต์ลง Google Calendar
    //         $savedEvent = $event->save();

    //         // อัปเดต database ให้เก็บ calendar_event_id
    //         DB::table('room_schedule')->where('schedule_id', $schedule->schedule_id)->update([
    //             'calendar_event_id' => $savedEvent->id,
    //             'calendar_status' => 1 // อัปเดตสถานะว่าส่งสำเร็จ
    //         ]);
    //     }

    //     return response()->json(['message' => count($schedules) . " รายการถูกเพิ่มใน Google Calendar"], 200);
    // }
   


    // public function cancel(Request $request, $id , $scheduleId)
    // {
    //     $booking = Booking::findOrFail($id);
    //     $reason = $request->input('cancel_reason', 'ไม่ระบุเหตุผล');

    //     $eventId = DB::table('room_schedule')->where('schedule_id', $scheduleId)->value('calendar_event_id');

    //      if (!$eventId) return false;

    //     $event = Event::find($eventId);
    //     if ($event) {
    //         $event->delete();
    //     }

    //     // อัปเดตฐานข้อมูลให้ calendar_status = 0 (ถูกลบ)
    //     DB::table('room_schedule')->where('schedule_id', $scheduleId)->update([
    //         'calendar_status' => 0,
    //         'calendar_event_id' => null
    //     ]);


    //     $booking->cancel($reason);
    //     if ($booking->roomschedules->isNotEmpty()) {
    //         RoomSchedule::cancelRoomSchedule($booking->roomschedules);
    //     }

    //     return redirect()->route('bookings')->with('success', 'Booking cancelled successfully.');
    // }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::with('roomschedules')->findOrFail($id);
        $reason = $request->input('cancel_reason', 'ไม่ระบุเหตุผล');

        // ดึงรายการ room_schedule ทั้งหมดที่มี booking_id ตรงกัน
        $roomSchedules = RoomSchedule::where('booking_id', $id)->get();

        if ($roomSchedules->isEmpty()) {
            return redirect()->route('bookings')->with('error', 'ไม่พบรายการจองในระบบ');
        }

        try {
            foreach ($roomSchedules as $roomSchedule) {
                if ($roomSchedule->calendar_event_id) {
                    // ลบ Event จาก Google Calendar
                    $event = Event::find($roomSchedule->calendar_event_id);
                    if ($event) {
                        $event->delete();
                    }
                }

                $roomSchedule->update([
                    'calendar_status' => 0,
                    'calendar_event_id' => null
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Google Calendar Error: " . $e->getMessage());
            return redirect()->route('bookings')->with('error', 'เกิดข้อผิดพลาดในการลบ Event ใน Google Calendar');
        }

        // อัปเดตสถานะการจอง
        $booking->cancel($reason);
        $booking->save();

        // ลบ Room Schedule ทั้งหมดที่เกี่ยวข้อง
        if ($booking->roomschedules->isNotEmpty()) {
            RoomSchedule::cancelRoomSchedule($booking->roomschedules);
        }

        return redirect()->route('bookings')->with('success', 'การจองถูกยกเลิกเรียบร้อยแล้ว');
    }




}