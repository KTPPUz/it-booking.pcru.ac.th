<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>IT-Booking Calendar</title>

    <link rel="icon" href="{{ asset('img/pcru.png') }}" type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="font-sans antialiased dark:text-white/50">

    @extends('layouts.app')

    @section('content')
        <div class="container-fluid">
            {{-- <div class="card">
                <div class="card-header text-center bg-orange">
                    <h4>ตรวจสอบห้องว่าง
                    </h4>
                </div>
            </div> --}}
            <div class="card mt-4">
                {{-- <div class="card-header text-center bg-danger">
                    <h4>รายงานปฏิทินการจอง</h4>
                </div> --}}
                <div class="card-body">

                    <div id="calendar" style="width: 100%; margin: 0 auto;"></div>
                    <br>
                    {{-- <div style="margin-left: 2.5%">
                        <b>หมายเหตุ:</b> <b style="color: orange;">สีส้ม คือ รายการที่กำลังดำเนินการ</b> <br>
                        <b style="color: green; margin-left: 4.5%">สีเขียว คือ รายการที่ดำเนินการเสร็จสิ้น </b>
                    </div> --}}
                </div>
            </div>
            {{-- <div class="card" style="background-color: #ffe261;">
                <div class="card-header text-left">DEBUG:</div>
                <div style="background-color: #ffefa7; padding: 10px;">

                    <pre>@json($events)</pre>
                </div>
            </div> --}}
            {{-- <div id="dynamicModalContainer"></div> --}}
        </div>


        <!-- Modal -->
        {{-- <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title" id="eventDetailModalLabel">รายละเอียดกิจกรรม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('bookingroom.modalcalender', ['schedules' => $schedules])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div> --}}
    @endsection


</body>

</html>


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    day: 'วัน'
                },
                locale: 'th',
                events: @json($events),

                selectable: false,
                editable: false,
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                height: 650,
                eventClick: function(info) {
                    // console.log(info.event.groupId);;
                    $('#eventDetailModal').modal('show');
                    $.ajax({
                        // url: '/bookingroom/' + info.event.groupId,
                        url: '/bookingroom/' + info.event.id,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            const htmlContent = '';
                            $('#eventDetailModal #eventDetailModalLabel').text(info.event
                                .title);

                            $('#eventDetailModal .modal-body').html(data);

                        },
                    });
                }
            });
            calendar.render();
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // สร้าง FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                initialView: 'dayGridMonth', // แสดงเดือนเป็นค่าเริ่มต้น
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek' // ตัวเลือกในการเปลี่ยนมุมมอง
                },
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์'
                },
                locale: 'th', // ใช้ภาษาไทย
                dayHeaderFormat: {
                    weekday: 'long' // แสดงวันในสัปดาห์เป็นภาษาไทย
                },
                events: @json($events), // ดึงข้อมูลอีเวนต์จากตัวแปร PHP
                editable: false, // ไม่อนุญาตให้ลากหรือแก้ไขอีเวนต์
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false // ใช้รูปแบบเวลา 24 ชั่วโมง
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false // ใช้รูปแบบเวลา 24 ชั่วโมง
                },
                height: 750, // ความสูงของปฏิทิน
                dateClick: function(info) {
                    var today = new Date();
                    var clickedDate = new Date(info.dateStr);

                    // รีเซ็ตเวลาเป็น 00:00:00 เพื่อตรวจสอบเฉพาะวันที่
                    today.setHours(0, 0, 0, 0);
                    clickedDate.setHours(0, 0, 0, 0);

                    // ตรวจสอบว่าคลิกวันที่ย้อนหลังหรือไม่
                    if (clickedDate < today) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่สามารถเลือกวันที่ย้อนหลังได้',
                            showConfirmButton: true
                        });
                        return false; // หยุดการทำงาน
                    }

                    // กดเลือกวันที่ในปฏิทิน
                    console.log('Date clicked:', info.dateStr);
                },

                select: function(info) {
                    var startDate = new Date(info.startStr);

                    // รีเซ็ตเวลาเป็น 00:00:00 เพื่อตรวจสอบเฉพาะวันที่
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);

                    // ตรวจสอบว่าเลือกวันเสาร์หรืออาทิตย์หรือไม่
                    if (startDate.getDay() === 0 || startDate.getDay() === 6) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่สามารถเลือกวันเสาร์หรืออาทิตย์ได้',
                            showConfirmButton: true
                        });
                        calendar.unselect(); // ยกเลิกการเลือก
                        return false; // หยุดการทำงาน
                    }

                    // ตรวจสอบว่าคลิกวันที่ย้อนหลังหรือไม่
                    if (startDate < today) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่สามารถเลือกวันที่ย้อนหลังได้',
                            showConfirmButton: true
                        });
                        calendar.unselect(); // ยกเลิกการเลือก
                        return false; // หยุดการทำงาน
                    }
                    console.log('Selected date:', info.startStr);
                    window.location.href = `/booking/newbookingc?start=${info.startStr}`;
                    return true; // อนุญาตการทำงานต่อ
                }


            });

            calendar.render(); // แสดงปฏิทิน
        });
    </script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    // day: 'วัน'
                },

                locale: 'th',
                dayHeaderFormat: {
                    weekday: 'long'
                },
                events: @json($events),

                selectable: false,
                editable: false,
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                height: 750,
                dateClick: function(info) {
                    console.log(info);
                },
                select: function(info) {
                    console.log(info);
                },
                // eventClick: function(info) {
                //     $('#eventDetailModal').modal('show');
                //     $.ajax({
                //         url: '/bookingroom/' + info.event.id,
                //         type: 'GET',
                //         success: function(data) {
                //             $('#eventDetailModal #eventDetailModalLabel').text(info.event
                //                 .title);
                //             $('#eventDetailModal .modal-body').html(data);
                //         },
                //     });
                // }

            });

            calendar.render();
        });
    </script> --}}
@endpush
