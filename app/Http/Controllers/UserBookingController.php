<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

use App\Models\UserBooking;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Department; 
use App\Models\Sect;
use App\Models\BookingType;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookingSend;


use Illuminate\Http\Request;

class UserBookingController extends Controller
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
    // public function create()
    // {
        
    // }

    public function addToBooking(Request $request, $roomId)
{
    $room = Room::findOrFail($roomId);
    $userId = auth()->user()->id;

    // ตรวจสอบว่ามีการจองซ้ำใน BookingRoom (สำหรับเวลาเดียวกัน)
    $isDuplicate = BookingRoom::where('room_id', $roomId)
        ->where('date', $request->ubooking_date)
        ->where(function ($query) use ($request) {
            $query->whereBetween('time_start', [$request->ubooking_timestart, $request->ubooking_timeend])
                ->orWhereBetween('time_end', [$request->ubooking_timestart, $request->ubooking_timeend])
                ->orWhere(function ($query) use ($request) {
                    $query->where('time_start', '<=', $request->ubooking_timestart)
                        ->where('time_end', '>=', $request->ubooking_timeend);
                });
        })
        ->exists();

    if ($isDuplicate) {
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'message' => 'ห้องนี้ถูกจองสำหรับการเรียนการสอนในวันที่และเวลาที่คุณเลือกแล้ว กรุณาเลือกห้องหรือเวลาอื่น',
        ]);
    }

    // ตรวจสอบว่าผู้ใช้คนเดียวกันมีการจองห้องนี้ในเวลาเดียวกันแล้วหรือไม่ (UserBooking)
    $isUserDuplicate = UserBooking::where('user_id', $userId)
        ->where('room_id', $roomId)
        ->where('ubooking_date', $request->ubooking_date)
        ->where(function ($query) use ($request) {
            $query->whereBetween('ubooking_timestart', [$request->ubooking_timestart, $request->ubooking_timeend])
                ->orWhereBetween('ubooking_timeend', [$request->ubooking_timestart, $request->ubooking_timeend])
                ->orWhere(function ($query) use ($request) {
                    $query->where('ubooking_timestart', '<=', $request->ubooking_timestart)
                        ->where('ubooking_timeend', '>=', $request->ubooking_timeend);
                });
        })
        ->exists();

    if ($isUserDuplicate) {
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'message' => 'คุณได้ทำการเพิ่มห้องนี้ในวันที่และเวลาที่คุณเลือกลงในตะกร้าแล้ว กรุณาเลือกเวลาอื่น',
        ]);
    }

    // ตรวจสอบค่าลำดับ `no` สูงสุด
    // $maxNo = UserBooking::where('room_id', $roomId)->max('no') ?? 0;
    $maxNo = UserBooking::where('user_id', $userId)->max('no') ?? 0;
    // เพิ่มรายการใหม่ใน UserBooking
    UserBooking::create([
        'user_id' => $userId,
        'room_id' => $roomId,
        'ubooking_date' => $request->ubooking_date,
        'ubooking_timestart' => $request->ubooking_timestart,
        'ubooking_timeend' => $request->ubooking_timeend,
        'participant_count' => $request->participant_count,
        'no' => $maxNo + 1,
    ]);

    return redirect()->back()->with('alert', [
        'type' => 'success',
        'message' => 'เพิ่มห้องลงในตะกร้าสำเร็จ',
    ]);
}




public function removeFromBooking($roomId, Request $request)
{
    $userId = auth()->user()->id;

    // ค้นหารายการเฉพาะที่ต้องการลบในตาราง UserBooking
    $booking = UserBooking::where('user_id', $userId)
        ->where('room_id', $roomId)
        ->where('no', $request->no) // เพิ่มเงื่อนไขตรวจสอบ no
        ->first();

    if ($booking) {
        // ลบรายการที่ค้นพบ
        UserBooking::where('user_id', $userId)->where('room_id', $roomId)->where('no', $request->no)->delete();

        return redirect()->route('userbooking.show')->with('success', 'ลบรายการที่เลือกออกจากตะกร้าเรียบร้อยแล้ว!');
    }

    // ถ้าไม่พบรายการ
    return redirect()->route('userbsoking.show')->with('error', 'ไม่พบรายการที่คุณต้องการลบในตะกร้า!');
}



    public function confirmBooking(Request $request)
    {
        $userId = auth()->user()->id;
        $cartItems = UserBooking::where('user_id', $userId)->get();
        $booking = new Booking();
        $booking->user_id = $userId;
        $booking->sent_dt = now();
        $booking->department_id = $request->department_id;
        $booking->sect_id = $request->sect_id;
        $booking->is_ext = $request->type_id;
        $booking->send();

        Mail::to('st641102064110@pcru.ac.th')
            ->send(new BookingSend($booking));

        // $booking->status = 'pending';
        $booking->save();

        foreach ($cartItems as $cartItem) {
            $lastBookingRoom = BookingRoom::where('booking_id', $booking->booking_id)
            ->orderBy('no', 'desc')
            ->first();

            
            $bookingRoom = new BookingRoom();
            $bookingRoom->booking_id = $booking->booking_id;
            $bookingRoom->room_id = $cartItem->room_id;
            $bookingRoom->date = $cartItem->ubooking_date;
            $bookingRoom->time_start = $cartItem->ubooking_timestart;
            $bookingRoom->time_end = $cartItem->ubooking_timeend;
            $bookingRoom->no = $lastBookingRoom ? $lastBookingRoom->no + 1 : 1;
            $bookingRoom->participant_count = $cartItem->participant_count;
            $bookingRoom->save();
        }

        UserBooking::where('user_id', $userId)->delete();

        return redirect()->route('userbooking.show')->with('success', 'Booking confirmed!');
    }



    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

        $userId = auth()->user()->id;
        $cartItems = UserBooking::where('user_id', $userId)->get();
        $count = $cartItems->count();

        $departments = Department::all();
        $sects = Sect::all();

        $booking_type = BookingType::all();
        return view('userbooking.showbooking', compact('cartItems' , 'count' , 'departments' , 'sects' , 'booking_type'));
    }

    public function getSects($department_code)
    {
        $sects = Sect::where('department_code', $department_code)->get();

        return response()->json($sects);
    }

}