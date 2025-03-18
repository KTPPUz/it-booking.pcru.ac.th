<!DOCTYPE html>
<html>

<head>
    <title>Booking Reviewed</title>
    @include('cssjs.css')
</head>

<body>

    รายการจองห้อง : <span class="badge text-bg-success">{{ $booking->rooms->first()->room_name }}

    </span>
    <br>
    วันที่ : <span
        class="badge text-bg-success">{{ \Carbon\Carbon::parse($booking->bookingRooms->first()->date)->locale('th')->translatedFormat('d F Y') }}</span>
    <br>
    เวลา : <span
        class="badge text-bg-success">{{ \Carbon\Carbon::parse($booking->bookingRooms->first()->time_start)->format('H:i') }}
        - {{ \Carbon\Carbon::parse($booking->bookingRooms->first()->time_end)->format('H:i') }}</span>

    ได้รับการอนุมัติการจองเรียบร้อย

    @include('cssjs.js')
</body>

</html>
