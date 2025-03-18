<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header bg-danger">
            <h5 class="modal-title " id="reviewRoomModalLabel">
                พิจารณาการยกเลิกการจองห้อง
                {{-- booking_id {{ $booking->booking_id }}
                 / review_status: <spanid="currentReviewStatus">{{ $booking->review_status }}</spanid=> --}}
            </h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="cancelForm-{{ $booking->booking_id }}"
                action="{{ route('booking.cancel', $booking->booking_id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row mb-3">
                    <div class="form-group">
                        <div class="mb-3">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                <label for="cancel_reason" class="form-label">
                                    <h5>เหตุผลการยกเลิก</h5>
                                </label>
                                <input type="text" class="form-control" id="cancel_reason" name="cancel_reason"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                <b style="color:red;">หมายเหตุ : กรุณาทำการยกเลิกก่อนถึงวันใช้งานไม่เกิน 3 วัน</b>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary"
                                onclick="confirmCancel({{ $booking->booking_id }})">บันทึกข้อมูล</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmCancel(bookingId) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่ว่าต้องการยกเลิกการจองนี้?',
            text: "การกระทำนี้ไม่สามารถยกเลิกได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ยกเลิกการจอง!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancelForm-' + bookingId).submit();
            }
        });
    }
</script>
