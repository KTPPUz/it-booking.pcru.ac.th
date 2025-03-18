<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storestaff_usersRequest;
use App\Http\Requests\Updatestaff_usersRequest;
use App\Models\StaffUser;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\StaffType;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StaffUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffUsers = StaffUser::all(); // ดึงข้อมูลทั้งหมด
        $stafftypes = StaffType::all();
        return view('staff.index', compact('staffUsers' , 'stafftypes')); // ส่งไปยัง View
    }

    public function homestaff(){
        $events = HomeController::fetchEvent();

        return view('staff.homestaff', ['events' => $events]);
    }


    public function index_all(){
        $bookings = Booking::all();
        $bookingrooms = BookingRoom::all();

         $attrConfig = Booking::getAttributeOptions('state');
        $attrConfigdoc = Booking::getArrtibuteOptions('doc_status');


        return view('staff.bookingall', compact('bookings' , 'bookingrooms' , 'attrConfig' , 'attrConfigdoc'));
    }

    public function statistics(){
        
        $bookingss = Booking::whereDate('created_at', now()->toDateString())->get()->count();
        $bookingsc = Booking::all()->count();
        $totalParticipants = DB::table('booking_room')->sum('participant_count');
        
            //    dd($totalParticipants);
        $today = Carbon::today()->toDateString();
     
        $todayParticipant = DB::table('booking_room')
            ->whereDate('date', Carbon::today()->toDateString())
            ->sum('participant_count');

        $year = Carbon::now()->year;

        $monthlyBookings = array_fill(1, 12, 0);

        $bookings = DB::table('booking')
            ->select(DB::raw('MONTH(created_at) as month, COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        foreach ($bookings as $booking) {
            $monthlyBookings[$booking->month] = $booking->total;
        }

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            // $thaiMonths = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
            // $labels[] = $thaiMonths[$i - 1]; // แปลงเป็นชื่อเดือนภาษาไทย ม.ค., ก.พ., ...
            $labels[] = date("M", mktime(0, 0, 0, $i, 1)); // แปลงเป็นชื่อเดือน Jan, Feb, ...
            $data[] = $monthlyBookings[$i]; // นับจำนวนการจองของแต่ละเดือน
        }
        // $attrConfig = Booking::getAttributeOptions('state');
        // $attrConfigdoc = Booking::getArrtibuteOptions('doc_status');

        return view('staff.statistics', compact('bookingss' , 'bookingsc' , 'todayParticipant', 'totalParticipants' , 'labels', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create'); // ฟอร์มสำหรับเพิ่มข้อมูล
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff_users,email',
            'password' => 'required|string|min:8',
            'department_id' => 'nullable|integer',
            'sect_id' => 'nullable|integer',
            'type_id' => 'nullable|integer|exists:staff_type,staff_type_id',
        ]);

        StaffUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'department_id' => $request->department_id,
            'sect_id' => $request->sect_id,
            'type_id' => $request->type_id,
        ]);

        return redirect()->route('staff.index')->with('success', 'เพิ่มผู้ใช้งานสำเร็จ');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $staffUser = StaffUser::findOrFail($id);
        return view('staff.edit', compact('staffUser')); // ส่งข้อมูลไปยังฟอร์มแก้ไข
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff_users,email,' . $id . ',staff_id',
            'department_id' => 'nullable|integer',
            'sect_id' => 'nullable|integer',
            'password' => 'nullable|string|min:8',
            'type_id' => 'nullable|integer|exists:staff_type,staff_type_id',
        ]);

        $staffUser = StaffUser::findOrFail($id);
        $staffUser->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $staffUser->password, // อัปเดตรหัสผ่านถ้ามี
            'department_id' => $request->department_id,
            'sect_id' => $request->sect_id,
            'type_id' => $request->type_id,
        ]);

        return redirect()->route('staff.index')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $staffUser = StaffUser::findOrFail($id);
        $staffUser->delete();
        return redirect()->route('staff.index')->with('success', 'ลบผู้ใช้งานสำเร็จ');
    }




}