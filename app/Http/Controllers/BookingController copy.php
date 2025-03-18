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


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'department', 'sect'])
            ->where('user_id', auth()->user()->id)
            ->get();

        $room = Room::all();
        $bookingrooms = BookingRoom::all();

        $attrConfig = Booking::getAttributeOptions('state');
        $attrConfigdoc = Booking::getArrtibuteOptions('doc_status');

        return view('booking.index', compact('bookings', 'room', 'attrConfig' , 'attrConfigdoc' , 'bookingrooms'));
    }


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
      /**
     * Update the specified resource in storage.
     */

    // public function newupdate(Request $request) {
    //     // $validated = $request->validate([
    //     //     'department_id' => 'required|exists:department,department_id',
    //     //     'sect_id' => 'required|exists:sect,sect_id',
    //     //     'is_ext' => 'required|exists:booking_type,type_id',
    //     //     'room_id' => 'required|exists:room,room_id',
    //     //     'date' => 'required|date',
    //     //     'time_start' => 'required|date_format:H:i',
    //     //     'time_end' => 'required|date_format:H:i|after:time_start',
    //     //     'participant_count' => 'required|integer|min:1',
    //     // ]);
    //     // dd($validated);
    //     DB::beginTransaction(); // เริ่มทำงานในรูปแบบ Transaction
    //     try {
    //         // $booking = Booking::create([
    //         //     'user_id' => auth()->id(),
    //         //     'department_id' => $validated['department_id'],
    //         //     'sect_id' => $validated['sect_id'],
    //         //     'is_ext' => $validated['is_ext'],
    //         //     'sent_dt' => now(),
    //         // ]);

    //         $booking = new Booking();
    //         $booking->user_id = auth()->id();
    //         $booking->department_id = $request->department_id;
    //         $booking->sect_id = $request->sect_id;
    //         $booking->is_ext = $request->type_id;
    //         $booking->sent_dt = now();
    //         $booking->send();

    //         Mail::to('st641102064110@pcru.ac.th')
    //         ->send(new BookingSend($booking));
            
    //         $booking->save();
            
    //         // BookingRoom::create([
    //         //     'booking_id' => $booking->booking_id,
    //         //     'room_id' => $validated['room_id'],
    //         //     'date' => $validated['date'],
    //         //     'time_start' => $validated['time_start'],
    //         //     'time_end' => $validated['time_end'],
    //         //     'participant_count' => $validated['participant_count'],
    //         //     'no' => 1, 
    //         // ]);

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
    //         return redirect()->route('bookings')->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
    //     }
    // }

    // public function newupdate(Request $request) {
    //     DB::beginTransaction(); 
    //     try {
    //         $booking = new Booking();
    //         $booking->user_id = auth()->id();
    //         $booking->department_id = $request->department_id;
    //         $booking->sect_id = $request->sect_id;
    //         $booking->is_ext = $request->type_id;
    //         $booking->sent_dt = now();
    //         $booking->send();

    //         Mail::to('st641102064110@pcru.ac.th')
    //             ->send(new BookingSend($booking));
            
    //         $booking->save();

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

    //         if ($overlappingBookings && $request->type_id != 3) {
    //             return redirect()->route('br.newbooking')->with('error', 'มีการจองห้องในช่วงเวลานี้แล้ว');
    //         }

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
    //         return redirect()->route('bookings')->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
    //     }
    // }

     public function newupdate(Request $request) {
        DB::beginTransaction(); 
        try {

            $booking = new Booking();
            $booking->user_id = auth()->id();
            $booking->department_id = $request->department_id;
            $booking->sect_id = $request->sect_id;
            $booking->is_ext = $request->type_id;
            $booking->sent_dt = now();
            $booking->send();

            Mail::to('st641102064110@pcru.ac.th')
                ->send(new BookingSend($booking));
            
            $booking->save();

            // if ($request->filled('time_start') && $request->filled('time_end')) {
            //     $overlappingBookings = BookingRoom::where('room_id', $validated['room_id'])
            //         ->where('date', $validated['date'])
            //         ->where(function ($query) use ($validated) {
            //             $query->whereBetween('time_start', [$validated['time_start'], $validated['time_end']])
            //                 ->orWhereBetween('time_end', [$validated['time_start'], $validated['time_end']])
            //                 ->orWhere(function ($query) use ($validated) {
            //                     $query->where('time_start', '<=', $validated['time_start'])
            //                         ->where('time_end', '>=', $validated['time_end']);
            //                 });
            //         })
            //         ->exists();

            //     if ($overlappingBookings) {
            //         return redirect()->route('br.newbooking')->with('error', 'มีการจองห้องในช่วงเวลานี้แล้ว');
            //     }
            // }

            if ($request->filled('time_start') && $request->filled('time_end')) {
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
                    ->exists();
                if ($overlappingBookings) {
                    return redirect()->route('br.newbooking')->with('error', 'มีการจองห้องในช่วงเวลานี้แล้ว');
                }
            }



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
            return redirect()->route('bookings')->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
    
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
        $booking = Booking::findOrFail($request->id);
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
        // $booking = Booking::findOrFail($id);
        $booking = Booking::with('rooms')->findOrFail($id);

        $booking->review_comment = $request->review_comment;
        $booking->review_status = $request->review_status;

        $booking->revieww($request->review_status);

        $booking->save();

        RoomSchedule::generateRoomSchedule($booking->rooms);

        Mail::to($booking->user->email)
            ->send(new BookingReviewed($booking));

        return redirect()->route('review.index')->with('success', 'อนุมัติ และส่งอีเมล์แจ้งเตือนเรียบร้อยแล้ว');
    }



    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $reason = $request->input('cancel_reason', 'ไม่ระบุเหตุผล');

        $booking->cancel($reason);
        RoomSchedule::cancelRoomSchedule($booking->roomschedules);

        return redirect()->route('bookings')->with('success', 'Booking cancelled successfully.');
    }




    


}