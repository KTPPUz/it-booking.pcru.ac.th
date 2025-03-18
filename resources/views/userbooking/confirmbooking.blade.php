<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createconfirmbookingModalLabel">เลือกหน่วยงานที่ต้องการจอง
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('userbooking.confirm') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="type_id" class="form-label"><b>จองสำหรับ</b></label>
                    <select class="form-control" name="type_id" id="type_id" required>
                        <option value="" disabled>จองสำหรับ</option>
                        @foreach ($booking_type as $booking_type)
                            <option value="{{ $booking_type->type_id }}"
                                {{ isset($booking) && $booking->type_id == $booking_type->type_id ? 'selected' : '' }}>
                                {{ $booking_type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="department_id" class="form-label"><b>เลือกหน่วยงาน</b></label>
                    <select class="form-control" name="department_id" id="department_id" required>
                        <option value="" disabled>เลือกหน่วยงาน</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}"
                                department_code="{{ $department->department_code }}"
                                {{ isset($booking) && $booking->department_id == $department->department_id ? 'selected' : '' }}>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="sect_id" class="form-label"><b>หน่วยงานย่อย</b></label>
                    <select class="form-control" name="sect_id" id="sect_id" required disabled>
                        <option value="" disabled>หน่วยงานย่อย</option>
                        @if (isset($booking) && $booking->sect)
                            <option value="{{ $booking->sect_id }}" selected>{{ $booking->sect->sect_name }}
                            </option>
                        @endif
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">ทำการจอง</button>
                </div>

            </form>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const ubookingdate = document.getElementById('ubookingdate');
            if (ubookingdate) {
                ubookingdate.setAttribute('min', today);
            }
        });
        $(document).ready(function() {
            $('#ubookingtimestart').timepicker({
                'timeFormat': 'H:i:s'
            });
            $('#ubookingtimeend').timepicker({
                'timeFormat': 'H:i:s'
            });
        });



        $(document).ready(function() {
            var initialDepartmentCode = $('#department_id').find(':selected').attr('department_code');
            var initialSectId = "{{ isset($booking) ? $booking->sect_id : '' }}";

            if (initialDepartmentCode) {
                loadSects(initialDepartmentCode, initialSectId);
                $('#sect_id').prop('disabled', false);
            }

            $('#department_id').on('change', function() {
                var departmentCode = $(this).find(':selected').attr('department_code');

                if (departmentCode) {
                    $('#sect_id').prop('disabled', false);
                    loadSects(departmentCode);
                } else {
                    $('#sect_id').prop('disabled', true).empty().append(
                        '<option value="" disabled selected>เลือกสาขา</option>');
                }
            });

            function loadSects(departmentCode, selectedSectId = null) {
                $.ajax({
                    url: '/get-sects/' + departmentCode,
                    type: 'GET',
                    success: function(data) {
                        $('#sect_id').empty().append(
                            '<option value="" disabled selected>เลือกสาขา</option>');
                        $.each(data, function(key, sect) {
                            $('#sect_id').append('<option value="' + sect.sect_id + '"' + (sect
                                    .sect_id == selectedSectId ? ' selected' : '') + '>' +
                                sect.sect_name + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endpush
