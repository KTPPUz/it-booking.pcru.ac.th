@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="width:100%">
        <div class="card">

            <div class="card-header text-center bg-warning">
                <h3>จัดการข้อมูลการจอง</h3>
            </div>
            <div class=" card-body">
                <div class="mb-3" style="margin-left:95%">
                    <a href="{{ route('bookings') }}" class="btn btn-primary">
                        กลับ
                    </a>
                </div>
                <form action="{{ route('bupdate', $booking->booking_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- <div class="row mb-3" style="margin-left:10px;">
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12 col-xs-12">
                            <label for="is_classroom" class="form-label"><b>จองสำหรับการเรียนการสอน</b></label><br>
                            <input type="checkbox" id="is_classroom" name="is_classroom" value="1"
                                {{ $booking->is_classroom == '1' ? 'checked' : '' }}>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12 col-xs-12">
                            <label for="is_ext" class="form-label"><b>จองสำหรับอบรม</b></label><br>
                            <input type="checkbox" id="is_ext" name="is_ext" value="1"
                                {{ $booking->is_ext == '1' ? 'checked' : '' }}>
                        </div>
                    </div> --}}

                    <div class="row" style="margin-left:10px;">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
                            <label for="type_id" class="form-label"><b>จองสำหรับ</b></label>
                            <select class="form-select" name="type_id" id="type_id" required>
                                <option value="" disabled {{ !isset($booking) ? 'selected' : '' }}>กรุณาเลือก</option>
                                @foreach ($bookingtype as $bookingtypee)
                                    <option value="{{ $bookingtypee->type_id }}"
                                        {{ isset($booking) && $booking->type_id == $bookingtypee->type_id ? 'selected' : '' }}>
                                        {{ $bookingtypee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row" style="margin-left:10px;">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
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

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
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
                    <div style="margin-left:20px;">
                        <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                    </div>



                </form>

            </div>
        </div>
        <div class="card">
            <div class=" card-body">
                <form action="{{ route('bookingroom.update', $booking->booking_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-3" style="margin-left:20px;">
                        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal"
                            data-bs-target="#createbookingroomModal">
                            <i class="fas fa-plus"></i> วันที่จองและห้อง
                        </button>
                        <div class="modal fade" id="createbookingroomModal" tabindex="-1"
                            aria-labelledby="createbookingroomModalLabel" aria-hidden="true">
                            @include('bookingroom.create')
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <td align="center" width="8%">ห้อง</td>
                            <td align="center" width="8%">จำนวนผู้เข้าใช้</td>
                            <td align="center" width="8%">วันที่จอง</td>
                            <td align="center" width="8%">เวลาเริ่ม</td>
                            <td align="center" width="8%">เวลาสิ้นสุด</td>
                            <!-- <td align="center" width="5%">Edit</td> -->
                            <td align="center" width="5%">DELETE</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking->rooms as $room)
                            <tr>
                                <td align="center">{{ $room->room_name ?? '' }}</td>
                                <td align="center">{{ $room->pivot->participant_count }}</td>
                                <td align="center">{{ \Carbon\Carbon::parse($room->pivot->date)->format('d/m/Y') }}</td>
                                <td align="center">{{ $room->pivot->time_start }}</td>
                                <td align="center">{{ $room->pivot->time_end }}</td>
                                <td width="3%" align="center">
                                    @if (isset($booking->booking_id, $room->pivot->no))
                                        <form id="delete-form-{{ $booking->booking_id }}-{{ $room->pivot->no }}"
                                            action="{{ route('bkdestroy', ['booking_id' => $booking->booking_id, 'no' => $room->pivot->no]) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <a href="{{ route('bkdestroy', ['booking_id' => $booking->booking_id, 'no' => $room->pivot->no]) }}"
                                            class="btn btn-danger"
                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this room?')) { document.getElementById('delete-form-{{ $booking->booking_id }}-{{ $room->pivot->no }}').submit(); }">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    @else
                                        <span class="text-danger">Invalid booking or room</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            });

            document.addEventListener('DOMContentLoaded', function() {
                @if (session('alert'))
                    Swal.fire({
                        icon: "{{ session('alert')['type'] }}",
                        title: "{{ session('alert')['message'] }}",
                        showConfirmButton: true,
                    });
                @endif
            });
        </script>
    @endif
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('is_classroom').addEventListener('click', function() {
        //         if (this.checked) {
        //             document.getElementById('is_ext').checked = false;
        //         }
        //     });

        //     document.getElementById('is_ext').addEventListener('click', function() {
        //         if (this.checked) {
        //             document.getElementById('is_classroom').checked = false;
        //         }
        //     });
        // });


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
