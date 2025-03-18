<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\RoomSchedule as RS;
use App\Models\BookingRoom as BR;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = $this->fetchEvent();
        $schedules = RS::where('booking_id')->get();

        // dd($events); // Check what is being fetched

        return view('welcome', ['events' => $events , 'schedules' => $schedules]);
    }


    //     public function homestaff(){

    //     return view('homestaff');
    // }

    // static public function fetchEvent()
    // {
    //     $schedules = RS::all();
    //     $approved = $schedules->map(function ($schedule) {
    //         return [
    //             'id' => $schedule->schedule_id,
    //             'groupId' => $schedule->booking_id,
    //             'title' => $schedule->booking->booking_id,
    //             'start' => $schedule->dt_start,
    //             'end' => $schedule->dt_end,
    //             'backgroundColor' => 'green',
    //             // 'status' => $schedule->status,
    //             // 'calendar_event_id' => $schedule->calendar_event_id,
    //             // 'calendar_status' => $schedule->calendar_status,
    //         ];
    //     });

    //     // $br = BR::whereHas('booking', function ($query) {
    //     //     $query->where('doc_status', 0);
    //     // })->get();
    //     // $pending = $br->map(function ($booking) {
    //     //     return [
    //     //         // 'id' => $booking->booking_id,
    //     //         'id' => null,
    //     //         'groupId' => $booking->booking_id,
    //     //         'title' => $booking->booking_id,
    //     //         'start' => $booking->dt_start,
    //     //         'end' => $booking->dt_end,
    //     //         'backgroundColor' => 'red',
    //     //         // 'status' => $booking->status,
    //     //         // 'calendar_event_id' => $booking->calendar_event_id,
    //     //         // 'calendar_status' => $booking->calendar_status,
    //     //     ];
    //     // });

    //     // $events = $approved->merge($pending);

    //     // return response()->json($events);
    //     return response()->json($approved);
    // }

    // static public function fetchEvent()
    // {
    //     $schedules = RS::all();

        
    //     $approved = $schedules->map(function ($schedule) {
    //         $name = $schedule->room->room_name . ($schedule->booking->reason ? ' - ' . $schedule->booking->reason : '') . ' (ดำเนินการแล้ว)';

    //         return [
    //             'id' => $schedule->schedule_id,
    //             'groupId' => $schedule->booking_id,
    //             'title' => $name,
    //             'start' => $schedule->dt_start,
    //             'end' => $schedule->dt_end,
    //             'backgroundColor' => '#B6E2A1',
    //             'borderColor' => '#B6E2A1',
    //             'textColor' => '#000000',
    //             'room_id' => $schedule->room->room_id,
    //         ];
    //     });

    //     $br = BR::whereHas('booking', function ($query) {
    //         $query->where('doc_status', '!=', 2)
    //             ->where('review_status', 0);
    //     })->get();

    //     // $br = BR::all();

    //     $pending = $br->map(function ($br) {
    //         $name = $br->room->room_name . ($br->booking->reason ? ' - ' . $br->booking->reason : '') . ' (รอดำเนินการ)';
    //         $date = Carbon::parse($br->date)->format('Y-m-d');
    //         $timeStart = Carbon::parse($br->time_start)->format('H:i:s');
    //         $timeEnd = Carbon::parse($br->time_end)->format('H:i:s');
    //         $start = Carbon::parse("{$date} {$timeStart}")->format('Y-m-d H:i:s');
    //         $end = Carbon::parse("{$date} {$timeEnd}")->format('Y-m-d H:i:s');

    //         return [
    //             'id' => null,
    //             'groupId' => $br->booking_id,
    //             'title' => $name,
    //             'start' => $start,
    //             'end' => $end,
    //             'backgroundColor' => '#FEBE8C',
    //             'borderColor' => '#FEBE8C',
    //             'textColor' => '#000000',
    //             'room_id' => $br->room->room_id,
    //         ];
    //     });

        
    //     // Merge approved and pending events
    //     // $events = $approved->merge($pending);
    //     $events = collect($approved)->merge(collect($pending));

    //     // Return as a plain array, not a JSON response
    //     return $events->toArray();
    // }
 static public function fetchEvent()
{
    // Fetch all schedules
    // $schedules = RS::all() ;
    $schedules = RS::where('calendar_status', 1)->get();

    // Process approved events
    $approved = collect($schedules)->map(function ($schedule) {
        $roomName = $schedule->room->room_name ?? 'Unknown Room';
        $reason = $schedule->booking->reason ?? '';
        $isext = $schedule->booking->bookingtype->name ?? '';
        $name = $roomName . ($isext ? ' - ' . $isext : '') . ' (จองแล้ว)';

        return [
            'id' => $schedule->schedule_id,
            'groupId' => $schedule->booking_id,
            'title' => $name,
            'start' => $schedule->dt_start,
            'end' => $schedule->dt_end,
            'backgroundColor' => '#B6E2A1',
            'borderColor' => '#B6E2A1',
            'textColor' => '#000000',
            'room_id' => $schedule->room->room_id ?? null, // Handle missing room relationship
        ];
    });

    // Fetch pending events
    $br = BR::whereHas('booking', function ($query) {
        $query->where('doc_status', '!=', 4)
              ->where('training_id', 1)
            //   ->where(function ($query) {
            //       $query->where('training_id', 1);
            //   })
              ->where('review_status', 0);
    })->whereHas('bookingtype')->get();

    $pending = collect($br)->map(function ($br) {
        $roomName = $br->room->room_name ?? 'Unknown Room';
        $reason = $br->booking->reason ?? '';
        $isext = $br->bookingtype->name ?? '';
        $name = $roomName . ($isext ? ' - ' . $isext : '') . ' (รอดำเนินการ)';

        $date = Carbon::parse($br->date)->format('Y-m-d');
        $timeStart = Carbon::parse($br->time_start)->format('H:i:s');
        $timeEnd = Carbon::parse($br->time_end)->format('H:i:s');
        $start = Carbon::parse("{$date} {$timeStart}")->format('Y-m-d H:i:s');
        $end = Carbon::parse("{$date} {$timeEnd}")->format('Y-m-d H:i:s');

        return [
            'id' => null,
            'groupId' => $br->booking_id,
            'title' => $name,
            'start' => $start,
            'end' => $end,
            'backgroundColor' => '#FEBE8C',
            'borderColor' => '#FEBE8C',
            'textColor' => '#000000',
            'room_id' => $br->room->room_id ?? null, // Handle missing room relationship
        ];
    });

    // Merge approved and pending events
    $events = $approved->merge($pending);

    // Return as a plain array
    return $events->toArray();
}

//     static public function fetchEvent()
// {
//     // Fetch all schedules
//     $schedules = RS::all();

//     // Process approved events
//     $approved = $schedules->map(function ($schedule) {
//         $roomName = $schedule->room->room_name ?? 'Unknown Room';
//         $reason = $schedule->booking->reason ?? '';
//         $name = $roomName . ($reason ? ' - ' . $reason : '') . ' (ดำเนินการแล้ว)';

//         return [
//             'id' => $schedule->schedule_id,
//             'groupId' => $schedule->booking_id,
//             'title' => $name,
//             'start' => $schedule->dt_start,
//             'end' => $schedule->dt_end,
//             'backgroundColor' => '#B6E2A1',
//             'borderColor' => '#B6E2A1',
//             'textColor' => '#000000',
//             'room_id' => $schedule->room->room_id ?? null, // Handle missing room relationship
//         ];
//     });

//     // Fetch pending events
//     $br = BR::whereHas('booking', function ($query) {
//         $query->where('doc_status', '!=', 2)
//               ->where('review_status', 0);
//     })->get();

//     $pending = $br->map(function ($br) {
//         $roomName = $br->room->room_name ?? 'Unknown Room';
//         $reason = $br->booking->reason ?? '';
//         $name = $roomName . ($reason ? ' - ' . $reason : '') . ' (รอดำเนินการ)';

//         $date = Carbon::parse($br->date)->format('Y-m-d');
//         $timeStart = Carbon::parse($br->time_start)->format('H:i:s');
//         $timeEnd = Carbon::parse($br->time_end)->format('H:i:s');
//         $start = Carbon::parse("{$date} {$timeStart}")->format('Y-m-d H:i:s');
//         $end = Carbon::parse("{$date} {$timeEnd}")->format('Y-m-d H:i:s');

//         return [
//             'id' => null,
//             'groupId' => $br->booking_id,
//             'title' => $name,
//             'start' => $start,
//             'end' => $end,
//             'backgroundColor' => '#FEBE8C',
//             'borderColor' => '#FEBE8C',
//             'textColor' => '#000000',
//             'room_id' => $br->room->room_id ?? null, // Handle missing room relationship
//         ];
//     });

//     // Merge approved and pending events
//     $events = $approved->merge($pending);

//     // Return as a plain array
//     return $events->toArray();
// }



}