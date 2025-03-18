<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="assetLocationCModalLabel">เพิ่มข้อมูลกลุ่มอุปกรณ์</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('assetlocation.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="asset_id"> รหัสอุปกรณ์วิชาการ</label>
                    <select name="asset_id" id="asset_id" class="form-control" required>
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->asset_id }}">{{ $asset->asset_ac_id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="room_id">ห้อง</label>
                    <select name="room_id" id="room_id" class="form-control">
                        <option value="">เลือกห้อง</option> <!-- เพิ่มตัวเลือกว่าง -->
                        @foreach ($rooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
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


                <div class="form-group mb-3">
                    <label for="location_type">ประเภทสถานที่</label>
                    <select name="location_type" id="location_type" class="form-control" required>
                        <option value="room">room</option>
                        <option value="outside">outside</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="is_current">Is Current:</label>
                    <select name="is_current" id="is_current" class="form-control" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
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
