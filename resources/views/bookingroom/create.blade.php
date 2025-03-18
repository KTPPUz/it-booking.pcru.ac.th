<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createbookingroomModalLabel">เพิ่มข้อมูลวันที่จองและห้อง</h5>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
            <form action="{{ route('bookingroom.update', ['id' => $booking->booking_id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="room_id" class="form-label">เลือกห้อง</label>
                    <select class="js-example-basic-single form-control" name="room_id" id="room_id" required>
                        <option value="" selected>-- เลือกห้อง --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="participant_count" class="form-label">จำนวนผู้เข้าใช้</label>
                    <input type="text" class="form-control" id="participant_count" name="participant_count">
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">วันที่เข้าใช้</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <div class="mb-3">
                    <label for="time_start" class="form-label">เวลาเริ่ม</label>
                    <input id="timestart" name="time_start" type="text" placeholder="เลือกเวลาเริ่ม"
                        class="form-control">
                </div>
                <div class="mb-3">
                    <label for="time_end" class="form-label">เวลาสิ้นสุด</label>
                    <input id="timeend" name="time_end" type="text" placeholder="เลือกเวลาสิ้นสุด"
                        class="form-control">
                </div>





                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').setAttribute('min', today);
        });
        $(document).ready(function() {
            $('#timestart').timepicker({
                'timeFormat': 'H:i:s' // 24-Hour Format
            });
            $('#timeend').timepicker({
                'timeFormat': 'H:i:s' // 12-Hour Format with AM/PM
            });
        });
    </script>
@endpush
