@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" align="center">
                <h3>ข้อมูลการจอง</h3>
            </div>
            <div class="card-body" width="100%">
                {{-- <div class="text-end">
                    <a href="javascript:void(0);" class="btn btn-success" onclick="showSweetAlert()" data-toggle="tooltip"
                        title="สร้างใบขออนุมัติฝึกอบรม">
                        <i class="fas fa-plus"></i>
                    </a>
                </div> --}}
                <br>

                <table class="table">
                    <thead>
                        <tr>
                            <td align="center" width="5%"></td>
                            <td align="center" width="8%">ชื่อผู้จอง</td>
                            <td align="center" width="8%">จองสำหรับ</td>
                            {{-- <td align="center" width="8%">หน่วยงาน</td>
                            <td align="center" width="8%">สาขา</td> --}}
                            {{-- <td align="center" width="8%">เหตุผลการจอง</td> --}}
                            <td align="center" width="8%">สถานะการส่ง</td>
                            {{-- <td align="center" width="8%">สถานะ</td> --}}
                            <td align="center" width="5%">ยกเลิก</td>
                            <td align="center" width="5%">แก้ไข</td>
                            <td align="center" width="5%">ลบ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td align="center">
                                    <button class="btn btn-sm btn-primary btn-expand" data-id="{{ $booking->booking_id }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                                <td align="center">{{ $booking->user?->name ?? 'ไม่ระบุ' }}</td>
                                <td align="center">
                                    @if ($booking->is_ext == 1)
                                        <span class="badge badge text-white bg-info">อบรม</span>
                                    @elseif($booking->is_ext == 2)
                                        <span class="badge badge text-white bg-secondary">ประชุม</span>
                                    @elseif($booking->is_ext == 3)
                                        <span class="badge badge text-white bg-primary">การเรียนการสอน</span>
                                    @endif
                                </td>
                                {{-- <td align="center">{{ $booking->department?->department_name ?? '-' }}</td>
                                <td align="center">{{ $booking->sect?->sect_name ?? '-' }}</td> --}}
                                {{-- <td align="center">{{ $booking->reason }}</td> --}}
                                <td align="center">
                                    @php
                                        $label = $attrConfigdoc['label'][$booking->doc_status] ?? 'ไม่ระบุ';
                                        $class =
                                            $attrConfigdoc['class'][$booking->doc_status] ?? 'badge badge bg-danger';
                                    @endphp
                                    <span class="{{ $class }}">{{ $label }}</span>
                                </td>

                                @if ($booking->doc_status == 0)
                                    <td align="center" width="5%">
                                        <form id="send-form-{{ $booking->booking_id }}" action="{{ route('booking.send') }}"
                                            method="POST" style="display: none;">
                                            <input type="hidden" name="id" value="{{ $booking->booking_id }}">
                                            @csrf
                                        </form>
                                        <a href="javascript:void(0);" class="btn btn-warning" title="ส่ง"
                                            onclick="sendBooking({{ $booking->booking_id }});">
                                            <i class="fa-solid fa-share-from-square"></i>
                                        </a>
                                    </td>
                                @endif
                                @if ($booking->doc_status == 1 || $booking->doc_status == 2)
                                    <td align="center" width="5%">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#createreviewRoomModal">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                        <div class="modal fade" id="createreviewRoomModal" tabindex="-1"
                                            aria-labelledby="reviewRoomModalLabel" aria-hidden="true">
                                            @include('booking.cancel')
                                        </div>
                                    </td>
                                @endif
                                <td width="3%" align="center">
                                    @if ($booking->doc_status == 0)
                                        <form id="delete-form-{{ $booking->booking_id }}"
                                            action="{{ route('bdestroy', $booking->booking_id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="javascript:void(0);" class="btn btn-danger"
                                            onclick="deleteBooking({{ $booking->booking_id }});">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr id="expandRow{{ $booking->booking_id }}" style="display:none" class="hide">
                                <td colspan="12">
                                    <div class="card card-body">
                                        <strong>รายละเอียดเพิ่มเติม:</strong> <br>

                                        <table>
                                            <thead>
                                                <tr>
                                                    {{-- <td align="center" width="5%">ลำดับ</td> --}}
                                                    <td align="center" width="5%">ห้อง</td>
                                                    <td align="center" width="5%">จำนวนผู้เช้าใช้</td>
                                                    <td align="center" width="8%">วันที่ใช้</td>
                                                    <td align="center" width="8%">เวลาเริ่ม</td>
                                                    <td align="center" width="8%">เวลาสิ้นสุด</td>
                                                </tr>
                                            </thead>
                                            @foreach ($bookingrooms as $bookingroom)
                                                @if ($bookingroom->booking_id == $booking->booking_id)
                                                    <tr>
                                                        {{-- <td align="center">{{ $bookingroom->no }}</td> --}}
                                                        <td align="center">{{ $bookingroom->room->room_name }}</td>
                                                        <td align="center">{{ $bookingroom->participant_count }}</td>
                                                        <td align="center">
                                                            {{ \Carbon\Carbon::parse($bookingroom->date)->format('d/m/Y') }}
                                                        </td>
                                                        <td align="center">
                                                            {{ \Carbon\Carbon::parse($bookingroom->time_start)->format('H:i') }}
                                                        </td>
                                                        <td align="center">
                                                            {{ \Carbon\Carbon::parse($bookingroom->time_end)->format('H:i') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
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
    <script>
        $(document).ready(function() {

            $('.btn-expand').on('click', function() {
                const button = $(this);
                const icon = button.find('i');
                const id = button.data('id');
                $('#expandRow' + id).toggle();
            });
        });


        function showSweetAlert() {
            Swal.fire({
                title: 'คุณต้องการ "สร้างการจองห้อง" ใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, สร้างเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('bcreate') }}";
                }
            });
        }

        function sendBooking(bookingId) {
            Swal.fire({
                // title: 'Are you sure you want to send this booking?',
                title: 'คุณต้องการ "ส่งใบขออนุมัติ" ใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ส่งเลย!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('send-form-' + bookingId).submit();
                }
            });
        }


        function deleteBooking(bookingId) {
            Swal.fire({
                // title: 'Are you sure you want to delete this booking?',
                title: 'คุณต้องการ "ลบการจอง" ใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + bookingId).submit();
                }
            });
        }
    </script>
@endpush
