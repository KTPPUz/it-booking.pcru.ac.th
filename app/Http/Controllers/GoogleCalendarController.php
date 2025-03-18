<?php

namespace App\Http\Controllers;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoogleCalendarController extends Controller
{
    public function syncRoomScheduleToGoogleCalendar()
    {
        // ดึงข้อมูลจากตาราง room_schedule ที่ยังไม่มี calendar_event_id
        $schedules = DB::table('room_schedule')
            ->whereNull('calendar_event_id') // ดึงเฉพาะที่ยังไม่มี Event ใน Calendar
            ->get();

        foreach ($schedules as $schedule) {
            // สร้าง Event ใหม่ใน Google Calendar
            $event = new Event;
            $event->name = "จองห้องประชุม #" . $schedule->room_id;
            $event->startDateTime = Carbon::parse($schedule->dt_start);
            $event->endDateTime = Carbon::parse($schedule->dt_end);
            $event->description = "รหัสการจอง: " . $schedule->booking_id;
            $event->location = "Phetchabun Rajabhat University";

            // บันทึกอีเวนต์ลง Google Calendar
            $savedEvent = $event->save();

            // อัปเดต database ให้เก็บ calendar_event_id
            DB::table('room_schedule')->where('schedule_id', $schedule->schedule_id)->update([
                'calendar_event_id' => $savedEvent->id,
                'calendar_status' => 1 // อัปเดตสถานะว่าส่งสำเร็จ
            ]);
        }

        return response()->json(['message' => count($schedules) . " รายการถูกเพิ่มใน Google Calendar"], 200);
    }


    // public function getEventsFromGoogleCalendar()
    // {
    //     $events = Event::get();

    //     return response()->json($events);
    // }
    public function getEventsFromGoogleCalendar()
    {
        // ดึงรายการอีเวนต์ทั้งหมดจาก Google Calendar
        $events = Event::get();

        // แปลงข้อมูลให้อยู่ในรูปแบบ JSON
        $formattedEvents = [];

        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->startDateTime->format('Y-m-d H:i:s'),
                'end' => $event->endDateTime->format('Y-m-d H:i:s'),
                'description' => $event->description ?? '',
                'location' => $event->location ?? '',
            ];
        }

        return response()->json($formattedEvents);
    }

}