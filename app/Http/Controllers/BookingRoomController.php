<?php

namespace App\Http\Controllers;

// use App\Http\Requests\Storeroom_typeRequest;
// use App\Http\Requests\Updateroom_typeRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\BookingRoom;
use App\Models\Booking;
use App\Models\RoomSchedule as RS;
use App\Models\Sect;
use App\Models\Department;
use App\Models\BookingType;

class BookingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookingroom = BookingRoom::all();
        $rooms = Room::all();
        $roomtypes = RoomType::all();

        return view('bookingroom.create', compact('bookingroom' , 'rooms', 'roomtypes'));
    }

    /**
     * Update the specified resource in storage.
     */
 
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $bookingroom = new BookingRoom();
        $bookingroom->booking_id = $booking->booking_id;

        if ($request->filled('time_start') && $request->filled('time_end')) {
            $existingBookingQuery = BookingRoom::where('room_id', $request->room_id)
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
                })
                ->exists();
            if ($existingBooking && $request->type_id != 3) {
                return redirect()->back()->with([
                    'alert' => [
                        'type' => 'error',
                         'message' => 'ห้องนี้ถูกจองสำหรับการเรียนการสอนในวันที่และเวลาที่คุณเลือกแล้ว กรุณาเลือกห้องหรือเวลาอื่น',
                    ]
                ]);
            }
        }
        $lastBookingRoom = BookingRoom::where('booking_id', $booking->booking_id)
            ->orderBy('no', 'desc')
            ->first();

        $bookingroom->no = $lastBookingRoom ? $lastBookingRoom->no + 1 : 1;
        $bookingroom->room_id = $request->room_id;
        $bookingroom->participant_count = $request->participant_count;
        $bookingroom->date = $request->date;
        $bookingroom->time_start = $request->time_start;
        $bookingroom->time_end = $request->time_end;
        

        $bookingroom->save();
        return redirect()->route('booking.edit', ['id' => $booking->booking_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($booking_id, $no)
    {
        $check = BookingRoom::where('booking_id', $booking_id)->where('no' , $no)->first();
        if($check) {
           $bookingroom = BookingRoom::where('booking_id', $booking_id)->where('no' , $no)->delete();
        }
        return redirect()->route('booking.edit', ['id' => $booking_id])->with('success', 'ลบข้อมูลการจองห้องสำเร็จ');
    }

    public static function showcalendar($id = null)
    {


        if ($id) {
            $schedules = RS::with('room')->where('schedule_id', $id)->get();
            
        } else {
            $schedules = RS::with('room')->get();
        }

        // return view('bookingroom.modalcalender', compact('schedules'));

        return $schedules;
    }
}