
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header" align="center">
            <h3>ราการรออนุมัติ</h3>
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
                        <!-- <td align="center" width="5%">รหัสการจอง</td> -->
                        <td align="center" width="8%">ชื่อผู้จอง</td>
                        <td align="center" width="8%">จองสำหรับ</td>
                        <td align="center" width="8%">หน่วยงาน</td>
                        <td align="center" width="8%">สาขา</td>
                        <td align="center" width="8%">จำนวนผู้เข้าใช้</td>
                        <td align="center" width="8%">เหตุผลการจอง</td>
                        <td align="center" width="8%">สถานะการส่ง</td>
                        <td align="center" width="8%">สถานะ</td>
                        <td align="center" width="5%">ส่งอนุมัติ</td>
                        <td align="center" width="5%">Edit</td>
                        <td align="center" width="5%">DELETE</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <!-- <td align="center">{{ $booking->booking_id }}</td>ea -->
                        <td align="center">{{ $booking->user?->name ?? 'ไม่ระบุ' }}</td>
                        <td align="center">
                            @if($booking->is_classroom == 1)
                            <span class="badge rounded-pill text-bg-primary">การเรียนการสอน</span>
                            @elseif($booking->is_ext == 1)
                            <span class="badge rounded-pill text-bg-danger">อบรม</span>
                            @else
                            -
                            @endif
                        </td>
                        <td align="center">{{ $booking->department?->department_name  }}</td>
                        <td align="center">{{ $booking->sect?->sect_name }}</td>
                        <td align="center"></td>
                        <td align="center">{{ $booking->reason }}</td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center" width="5%">
                            <a href="#" class="btn btn-info" title="แก้ไข">
                                <i class="fa-solid fa-share-from-square"></i>
                            </a>
                        </td>
                        <td align="center" width="5%">
                            <a href="{{ route('booking.edit', $booking->booking_id) }}" class="btn btn-warning" title="แก้ไข">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td width="3%" align="center">
                            <form id="delete-form-{{ $booking->booking_id }}"
                                action="{{ route('bdestroy', $booking->booking_id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <a href="{{ route('bdestroy', $booking->booking_id) }}" class="btn btn-danger"
                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this booking?')) { document.getElementById('delete-form-{{ $booking->booking_id }}').submit(); }">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection

<script>
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
    })
}
</script>
