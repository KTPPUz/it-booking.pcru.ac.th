@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-center bg-warning">
                <h3>รายการรออนุมัติ</h3>
            </div>
            <div class="card-body">
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <td align="center" width="5%">
                                {{-- <button class="btn btn-sm btn-primary btn-expand"><i class="fas fa-plus"></i> </button> --}}
                            </td>
                            <td align="center" width="8%">ชื่อผู้จอง</td>
                            <td align="center" width="8%">จองสำหรับ</td>
                            <td align="center" width="8%">หน่วยงาน</td>
                            <td align="center" width="8%">สาขา</td>
                            {{-- <td align="center" width="8%">เหตุผลการจอง</td> --}}
                            {{-- <td align="center" width="8%">สถานะการส่ง</td> --}}
                            <td align="center" width="8%">สถานะ</td>
                            <td width="5%">ส่งอนุมัติ</td>
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
                                <td align="center">{{ $booking->department?->department_name ?? 'N/A' }}</td>
                                <td align="center">{{ $booking->sect?->sect_name ?? 'N/A' }}</td>
                                {{-- <td align="center">{{ $booking->reason }}</td> --}}
                                {{-- <td align="center">{{ $booking->rooms()->get() }}</td> --}}
                                {{-- <td align="center"></td> --}}
                                <td align="center">
                                    @php
                                        $label = $attrreviewConfig['label'][$booking->doc_status] ?? 'ไม่ระบุ';
                                        $class =
                                            $attrreviewConfig['class'][$booking->doc_status] ?? 'badge badge-secondary';
                                    @endphp
                                    <span class="{{ $class }}">{{ $label }}</span>
                                </td>

                                <td width="5%">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editRoomModal{{ $booking->booking_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editRoomModal{{ $booking->booking_id }}" tabindex="-1"
                                        aria-labelledby="editRoomModalLabel{{ $booking->booking_id }}" aria-hidden="true">
                                        @include('review.edit', ['booking' => $booking])
                                    </div>
                                </td>
                            </tr>
                            <tr id="expandRow{{ $booking->booking_id }}" style="display:none" class="hide">
                                <td colspan="9">
                                    <div class="card card-body">
                                        <strong>รายละเอียดการจองเพิ่มเติม:</strong> <br>
                                        {{-- <div class="form-control mb-3" style="height: auto;" readonly>
                                            {{ $booking->reason }}</div> --}}
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

                // if (icon.hasClass('fa-plus')) {
                //     icon.removeClass('fa-plus');
                //     icon.addClass('fa-minus');
                //     $('#expandRow' + id).show();
                // } else {
                //     icon.removeClass('fa-minus');
                //     icon.addClass('fa-plus');
                //     $('#expandRow' + id).hide();
                // }

                $('#expandRow' + id).toggle();
            });
        });
    </script>
@endpush
