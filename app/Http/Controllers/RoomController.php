<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreroomRequest;
use App\Http\Requests\UpdateroomRequest;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\AssetLocation;
use App\Models\BookingType;
use App\Models\Department;
use App\Models\Sect;
use App\Models\RoomSchedule;
use App\Models\BookingRoom;
use App\Http\Controllers\HomeController;
use App\Models\Booking;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cache::flush();

        if (Cache::has('room')) {
            $rooms = Cache::get('room');
        }else{
            $rooms = Room::all();
            Cache::put('room', $rooms , 1000);
        }

        if(Cache::has('roomtype')){
            $roomtypes = Cache::get('roomtype');
        }else{
            $roomtypes = RoomType::all();
            Cache::put('roomtype', $roomtypes , 1000);
        }

        return view('room.index', compact('rooms', 'roomtypes'));
    }

    public function roomasset($id)
    {
        $rooms = Room::findOrFail($id); // Fetch the specific room by ID
        $roomtypes = RoomType::all(); // Fetch all room types
        $assetlocations = AssetLocation::where('room_id', $id)->get(); // Fetch assets linked to the room

        return view('room.roomasset', compact('rooms', 'roomtypes', 'assetlocations'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all(); // ดึงข้อมูลห้องทั้งหมด
        $roomtypes = RoomType::all();
        return view('room.create', compact('rooms', 'roomtypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'room_name' => 'required',
    //         'room_type' => 'required|exists:room_type,room_type', // ตรวจสอบว่า room_type มีอยู่ในตาราง room_type
    //         'capacity' => 'required|integer',
    //         'description' => 'required',
    //         'room_pic' => 'required|image|mimes:jpeg,png,jpg|max:5120'
    //     ]);


    //     if ($request->hasFile('room_pic')) {
    //             $imageName = time() . '_' . rand(10,1000) . '.' . $request->file('room_pic')->getClientOriginalExtension();
    //             $request->file('room_pic')->move(public_path('images'), $imageName);
    //         } else {
    //             $imageName = null;
    //         }

    //     $room = new Room();
    //     $room->room_name = $request->room_name;
    //     $room->room_type = $request->room_type; // แก้ไขจาก room_type เป็น room_type
    //     $room->capacity = $request->capacity;
    //     $room->description = $request->description;

    //     $room->room_pic = $imageName ? '' . $imageName : null;
    //     $room->save();
    //     Cache::forget('room');
    //     return redirect()->route('rooms')->with('success', 'Room created successfully.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'room_name' => 'required',
            'room_type' => 'required|exists:room_type,type_id',
            'capacity' => 'required|int',
            'description' => 'required',
            'room_pic.*' => 'required|image|mimes:jpeg,png,jpg '
        ]);

        $imageNames = [];

        $imagePath = base_path('public_html/images');
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0775, true);
        }

        if ($request->hasFile('room_pic')) {
            foreach ($request->file('room_pic') as $file) {
                $imageName = time() . '_' . rand(10, 1000) . '.' . $file->getClientOriginalExtension();
                $file->move($imagePath, $imageName);
                $imageNames[] = $imageName;
            }
        }

        $room = new Room();
        $room->room_name = $request->room_name;
        $room->room_type = $request->room_type;
        $room->capacity = $request->capacity;       
        $room->description = $request->description;
        $room->room_pic = !empty($imageNames) ? json_encode($imageNames) : null;
    
        //      dd($room->toArray());
        // exit();
    
        $room->save();

        Cache::forget('room');
        return redirect()->route('rooms')->with('success', 'Room created successfully.');
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show()
    {
        $rooms = Room::all();
        $roomtypes = RoomType::all();
        $bookingtype = BookingType::all();
        $sects = Sect::all();
        $departments = Department::all(); 
        return view('room.show', compact('rooms' , 'roomtypes' , 'bookingtype' , 'sects' , 'departments'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit($id)
    {
        $room = Room::find($id);
        $roomtypes = RoomType::all();
        return view('room.edit', compact('room', 'roomtypes'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        // ตรวจสอบความถูกต้องของข้อมูลที่รับเข้ามา
        $request->validate([
            'room_name' => 'required|string|max:255',
            'room_type' => 'required|exists:room_type,type_id',
            'capacity' => 'required|integer|min:1',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:0,1',
            'room_pic.*' => 'nullable|image|mimes:jpeg,png,jpg' 
        ]);
        
        $room->room_name = $request->room_name;
        $room->room_type = $request->room_type;
        $room->capacity = $request->capacity;
        $room->description = $request->description;
        $room->status = $request->status;

        $imageNames = $room->room_pic ? json_decode($room->room_pic, true) : [];

        if ($request->hasFile('room_pic')) {
            if (!empty($imageNames)) {
                foreach ($imageNames as $oldImage) {
                    $oldImagePath = public_path('images/' . $oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $imageNames = [];
            }
            foreach ($request->file('room_pic') as $file) {
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $imageName);
                $imageNames[] = $imageName;
            }
        }
        $room->room_pic = !empty($imageNames) ? json_encode($imageNames) : null;
        $room->save();
        Cache::forget('room');
        return redirect()->route('rooms')->with('success', 'Room updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if ($room) {
            if ($room->room_pic) {
                // Decode the JSON-encoded room_pic to get the list of image names
                $imageNames = json_decode($room->room_pic, true);
                if (is_array($imageNames) && !empty($imageNames)) {
                    foreach ($imageNames as $image) {
                        $imagePath = public_path('images/' . $image);
                        if (file_exists($imagePath)) {
                            try {
                                unlink($imagePath);
                            } catch (\Exception $e) {
                                // Log error if any image fails to delete
                                Log::error('Failed to delete image: ' . $image . ' with error: ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
            $room->delete();
            Cache::forget('room');
            return redirect()->route('rooms')->with('success', 'Room and associated images deleted successfully.');
        }

        return redirect()->route('rooms')->with('error', 'Room not found.');
    }



    public function showImage($filename)
    {
        $path = public_path('images/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return Response::file($path);
    }

    public function showImageRoom($filename)
    {
        $path = public_path('images/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return Response::file($path);
    }

    public function search(Request $request)
    {
         $roomtypeId = $request->input('roomtype');
        //  exit($roomtypeId);

        $roomtypes = RoomType::all();

        $rooms = Room::when($roomtypeId, function ($query, $roomtypeId) {
            return $query->where('room_type', $roomtypeId);
        })->with('roomtype')->get();
        // $rooms = Room::all();

        return view('room.show', compact('rooms', 'roomtypes'));
    }

    public function detail($id)
    {
        $room = Room::find($id);
        if (!$room) {
        return redirect()->route('rooms')->with('error', 'Room not found.');
    }
        $roomtypes = RoomType::all();
        return view('room.detail', compact('room', 'roomtypes'));
    }


    public static function searchroom()
    {
        $rooms = Room::all();
// $rooms = Room::has('bookingrooms')->get();
      
        return $rooms;
    }

    // public function checkAvailableRooms(Request $request){
    //     $rooms = RoomController::searchroom();
    //     $events = HomeController::fetchEvent();

    //     // $request->validate([
    //     //     'start_date' => 'required|date',
    //     //     'end_date' => 'required|date|after_or_equal:start_date',
    //     //     'room_id' => 'nullable|exists:room,room_id',
    //     // ]);

    //     $startDate = $request->start_date;
    //     $endDate = $request->end_date;
    //     $roomId = $request->room_id;

    //     $occupiedRoomsQuery = BookingRoom::whereBetween('date', [$startDate, $endDate]);
        
    //     // $occupiedRoomsQuery = RoomSchedule::whereBetween('dt_start', [$startDate, $endDate])
    //     //             ->orWhereBetween('dt_end', [$startDate, $endDate]);
                    
    //     if ($roomId) {
    //         $occupiedRoomsQuery->where('room_id', $roomId);
    //     }

    //     $occupiedRooms = $occupiedRoomsQuery->with(['room', 'booking.bookingtype' ,  'booking.bookingRooms'
    //     ])->get();

    //     $bookingDetails = [];
    //     foreach ($occupiedRooms as $occupiedRoom) {
    //         if ($occupiedRoom->booking) {
    //             $bookingDetails[$occupiedRoom->booking_id] = [
    //                 'is_ext' => $occupiedRoom->booking->is_ext,
    //                 'bookingtype_name' => $occupiedRoom->booking->bookingtype->name ?? null,
    //             ];
    //         }
    //     }
    //     return view('room.checkroom', compact('occupiedRooms', 'bookingDetails', 'startDate', 'endDate', 'roomId', 'rooms', 'events') );
    // }

    public function checkAvailableRooms(Request $request) {
        $rooms = RoomController::searchroom();
        $events = HomeController::fetchEvent();

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $roomId = $request->room_id;

        // if (!$startDate || !$endDate) {
        //     return back()->withErrors(['error' => 'กรุณาเลือกช่วงเวลาที่ต้องการตรวจสอบ']);
        // }

        // $occupiedRoomsQuery = RoomSchedule::where(function ($query) use ($startDate, $endDate) {
        //     $query->whereBetween('dt_start', [$startDate, $endDate])
        //         ->orWhereBetween('dt_end', [$startDate, $endDate])
        //         ->orWhere(function ($query) use ($startDate, $endDate) {
        //             $query->where('dt_start', '<=', $startDate)
        //                     ->where('dt_end', '>=', $endDate);
        //         });
        // });

        $occupiedRoomsQuery = RoomSchedule::whereBetween('dt_start', [$startDate, $endDate])
            ->orWhereBetween('dt_end', [$startDate, $endDate]);

        if ($roomId) {
            $occupiedRoomsQuery->where('room_id', $roomId);
        }

        $occupiedRooms = $occupiedRoomsQuery
            ->with(['room', 'booking.bookingtype', 'booking.bookingRooms'])
            ->get();

        $bookingDetails = [];
        foreach ($occupiedRooms as $occupiedRoom) {
            if ($occupiedRoom->booking) {
                $bookingDetails[$occupiedRoom->booking_id] = [
                    'is_ext' => $occupiedRoom->booking->is_ext ?? false,
                    'bookingtype_name' => $occupiedRoom->booking->bookingtype->name ?? '-',
                    'participant_count' => $occupiedRoom->booking->bookingRooms->sum('participant_count') ?? 0,
                ];
            }
        }

        return view('room.checkroom', compact('occupiedRooms', 'bookingDetails', 'startDate', 'endDate', 'roomId', 'rooms', 'events'));
    }


    // public function checkAvailableRooms(Request $request){
    //     $rooms = RoomController::searchroom();
    //     $events = HomeController::fetchEvent();

    //     $startDate = $request->start_date;
    //     $endDate = $request->end_date;
    //     $roomId = $request->room_id;

    //     $occupiedRoomsQuery = RoomSchedule::whereBetween('dt_start', [$startDate, $endDate])
    //         ->orWhereBetween('dt_end', [$startDate, $endDate]);
            
    //     if ($roomId) {
    //         $occupiedRoomsQuery->where('room_id', $roomId);
    //     }

    //     $occupiedRooms = $occupiedRoomsQuery->with(['room', 'booking.bookingtype'])->get();

    //     $bookingDetails = [];
    //     foreach ($occupiedRooms as $occupiedRoom) {
    //         if ($occupiedRoom->booking) {
    //             $bookingDetails[$occupiedRoom->booking_id] = [
    //                 'is_ext' => $occupiedRoom->booking->is_ext,
    //                 'bookingtype_name' => $occupiedRoom->booking->bookingtype->name ?? null,
    //             ];
    //         }
    //     }

    //     $bookingRoomIds = $occupiedRooms->pluck('booking_id')->unique();
    //     $bookingRooms = BookingRoom::whereIn('booking_id', $bookingRoomIds)->get();

    //     return view('room.checkroom', compact('occupiedRooms', 'bookingDetails', 'startDate', 'endDate', 'roomId', 'rooms', 'events', 'bookingRooms'));
    // }

}