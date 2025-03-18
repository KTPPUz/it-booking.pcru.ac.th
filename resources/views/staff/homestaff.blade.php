@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            {{-- <div class="card-header text-center">
                <h4>IT-Booking Calendar</h4>
            </div> --}}
            {{-- <div id="calendar" style="width: 70%; margin: 0 auto;" class="mb-3"></div> --}}
            <div id="calendar" style="width: 95%;  margin: 0 auto;" class="mb-2"></div>
            <br>
        </div>
        {{-- <div class="card" style="background-color: #ffe261;">
            <div class="card-header text-left">DEBUG:</div>
            <div style="background-color: #ffefa7; padding: 10px;">

                <pre>@json($events)</pre>
            </div>
        </div> --}}
    </div>
@endsection

@push('scripts')
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    {{-- FullCalendar Scheduler (License Required) --}}
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script> --}}


    <script>
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
                events: @json($events), // Preloaded events from the controller
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
                height: 800, // กำหนดความสูงที่ต้องการ
            });
            calendar.render();
        });
    </script>
@endpush
