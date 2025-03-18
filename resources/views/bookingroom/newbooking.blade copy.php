@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5><i class="fa-solid fa-bars"></i>
                เพิ่มข้อมูลในการจอง
            </h5>
        </div>
        <div class="card-body" width="100%">
            <form action="{{ route('br.newupdate', $booking->booking_id) }}" method="POST"
                enctype="multipart/form-data">
                {{-- <form action="#" method="POST" enctype="multipart/form-data"> --}}
                @csrf
                @method('PUT')

                <h5 class="timeline-header" style="color:black;">
                    <B><label style="color: #dc3545"><U>ส่วนที่ 1
                            </U></label>&nbsp;เลือกข้อมูลหน่วยงาน</B>
                </h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label for="type_id" class="form-label"><b>จองสำหรับ</b></label>
                        <select class="form-select" name="type_id" id="type_id" required>
                            <option value="" disabled {{ !isset($booking) ? 'selected' : '' }}>กรุณาเลือก
                            </option>
                            @foreach ($bookingtype as $bookingtypee)
                            <option value="{{ $bookingtypee->type_id }}"
                                {{ isset($booking) && $booking->type_id == $bookingtypee->type_id ? 'selected' : '' }}>
                                {{ $bookingtypee->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="department_id" class="form-label"><b>เลือกหน่วยงาน</b></label>
                        <select class="form-select custom_select2" name="department_id" id="department_id" required>
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sect_id" class="form-label"><b>หน่วยงานย่อย</b></label>
                            <select class="form-control custom_select2" name="sect_id" id="sect_id" required disabled>
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

                <h5 class="timeline-header mt-3" style="color:black;">
                    <B><label style="color: #dc3545"><U>ส่วนที่ 2
                            </U></label>&nbsp;เลือกข้อมูลห้อง วันที่จอง และเวลาการจอง</B>
                </h5>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="room_id" class="form-label">เลือกห้อง<b class="red">*</b></label>
                        <select class="js-example-basic-single form-control" name="room_id" id="room_id" disabled
                            required>
                            <option value="" selected>-- เลือกห้อง --</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->room_id }}"
                                {{ isset($booking) && $booking->room_id == $room->room_id ? 'selected' : '' }}>
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
                        <input type="date" class="form-control" id="date" name="date" required>
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

                <br>
                <div style="margin-left:20px;" align="center">
                    <a href="{{ route('bookings') }}" class="btn btn-danger">ย้อนกลับ</a>
                    <button type="submit" class="btn btn-success">ทำการจอง</button>
                </div>
            </form>
            {{-- @endif --}}
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
</script>
@endpush