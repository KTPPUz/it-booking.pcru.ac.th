@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5><i class="fa-solid fa-bars"></i>
                    ทำรายการจองห้องปฏิบัติการ
                </h5>
            </div>
            <div class="card-body" width="100%">
                <form action="{{ route('br.newupdate') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Section 1: Booking Details -->
                    <h5>ส่วนที่ 1: เลือกข้อมูลหน่วยงาน</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="type_id">จองสำหรับ</label>
                            <select name="type_id" class="form-select" required>
                                <option value="" disabled selected>กรุณาเลือก</option>
                                {{-- @foreach ($bookingtype as $type)
                                    <option value="{{ $type->type_id }}"
                                        {{ $booking->type_id == $type->type_id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach --}}
                                @foreach ($bookingtype as $type)
                                    <option value="{{ $type->type_id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="department_id" class="form-label"><b>เลือกหน่วยงาน</b></label>
                            <select class="form-select custom_select2" name="department_id" id="department_id" required
                                style="width: 100%">
                                <option value="" selected>เลือกหน่วยงาน</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}"
                                        department_code="{{ $department->department_code }}"
                                        {{ isset($booking) && $booking->department_id == $department->department_id ? 'selected' : '' }}>
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-6">
                            <label for="department_id">เลือกหน่วยงาน</label>
                            <select name="department_id" class="form-select custom_select2" required>
                                <option value="" disabled>เลือกหน่วยงาน</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}">
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sect_id" class="form-label"><b>หน่วยงานย่อย</b></label>
                                <select class="form-control custom_select2" name="sect_id" id="sect_id" required disabled
                                    style="width: 100%">
                                    <option value="" disabled>หน่วยงานย่อย</option>
                                    @if (isset($booking) && $booking->sect)
                                        <option value="{{ $booking->sect_id }}" selected>{{ $booking->sect->sect_name }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Section 2: Room Booking Details -->
                    <h5 class="mt-3">ส่วนที่ 2: เลือกข้อมูลห้อง วันที่ และเวลา</h5>
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <label for="room_id">เลือกห้อง</label>
                            <select name="room_id" class="form-select" required>
                                <option value="" disabled>-- เลือกห้อง --</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->room_id }}"
                                        {{ isset($booking) && $booking->room_id == $room->room_id ? 'selected' : '' }}>
                                        {{ $room->room_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="room_id">เลือกห้อง</label>
                            <select name="room_id" class="form-select" required>
                                <option value="">-- เลือกห้อง --</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->room_id }}"
                                        {{ isset($selectedRoom) && $selectedRoom->room_id == $room->room_id ? 'selected' : '' }}>
                                        {{ $room->room_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>


                    <div class="row mt-3">

                        <div class="col-md-3">
                            <label for="participant_count" class="form-label">จำนวนผู้เข้าใช้<b class="red">*</b></label>
                            <input type="text" class="form-control" id="participant_count" name="participant_count"
                                required>
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label">วันที่เข้าใช้<b class="red">*</b></label>
                            <input type="date" class="form-control" id="date" name="date" required
                                value="{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-3">
                            <label for="time_start" class="form-label">เวลาเริ่ม<b class="red">*</b></label>
                            <input id="timestart" name="time_start" type="text" placeholder="เลือกเวลาเริ่ม"
                                class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="time_end" class="form-label">เวลาสิ้นสุด<b class="red">*</b></label>
                            <input id="timeend" name="time_end" type="text" placeholder="เลือกเวลาสิ้นสุด"
                                class="form-control" required>
                        </div>
                    </div>

                    <div style="margin-top:20px;">
                        <b>
                            <p style="color:red;">กรุณาตรวจสองห้องว่างก่อนจะทำการจองนะครับ *</p>
                        </b>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('welcome') }}" class="btn btn-danger">ยกเลิก</a>
                        <button type="submit" class="btn btn-success">ทำการจอง</button>
                        {{-- @if (session('success'))
                            <button type="submit" class="btn btn-success">ทำการจอง</button>
                        @else
                            <button type="submit" class="btn btn-success">ทำการจอง</button>
                        @endif --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<style>
    .red {
        color: red;
    }
</style>
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

        $(document).ready(function() {
            $('#department_id').on('change', function() {
                var selectedDepartment = $(this).val();
                $('#sect_id option').each(function() {
                    var sectDepartment = $(this).data(
                        'department');
                    if (sectDepartment == selectedDepartment) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('#sect_id').val('').trigger('change');
            });

            $('#department_id').trigger('change');
        });

        // select2
        $(document).ready(function() {
            $('.custom_select2').select2({
                theme: 'bootstrap-5',
                placeholder: 'กรุณาเลือกตัวเลือก',
                allowClear: true
            });

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

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') }}',
                confirmButtonText: 'ตกลง'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: '{{ session('error') }}',
                confirmButtonText: 'ตกลง'
            });
        @endif
    </script>
@endpush
