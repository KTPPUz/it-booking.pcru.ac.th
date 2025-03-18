<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createcartRoomModalLabel">เพิ่มข้อมูลห้องที่ต้องการจองลงตะกร้า
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('userbooking.addToBooking', ['roomId' => $room->room_id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="ubooking_date" class="form-label">วันที่เข้าใช้<b style="color:red">*</b></label>
                    <input type="date" class="form-control" id="ubookingdate" name="ubooking_date" required>
                </div>
                <div class="mb-3">
                    <label for="ubooking_timestart" class="form-label">เวลาเริ่ม<b style="color:red">*</b></label>
                    <input id="ubookingtimestart" name="ubooking_timestart" type="text" placeholder="เลือกเวลาเริ่ม"
                        class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="participant_count" class="form-label">เวลาสิ้นสุด<b style="color:red">*</b></label>
                    <input id="ubookingtimeend" name="ubooking_timeend" type="text" placeholder="เลือกเวลาสิ้นสุด"
                        class="form-control" required>
                </div>

                {{-- participant_count --}}
                <div class="mb-3">
                    <label for="participant_count" class="form-label">จำนวนผู้เข้าใช้<b style="color:red">*</b></label>
                    <input id="participantcount" name="participant_count" type="text" placeholder="จำนวนผู้เข้าใช้"
                        class="form-control" required>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('ubookingdate').setAttribute('min', today);
        });

        $(document).ready(function() {
            $('#ubookingtimestart').timepicker({
                'timeFormat': 'H:i:s'
            });
            $('#ubookingtimeend').timepicker({
                'timeFormat': 'H:i:s'
            });
        });
    </script>
@endpush
