@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" align="center">
                <h3>ข้อมูลห้อง</h3>
            </div>
            <div class="card-body">
                <div class="text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                        <i class="fas fa-plus"></i> เพิ่มข้อมูล
                    </button>
                </div>
                <div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModalLabel"
                    aria-hidden="true">
                    @include('room.create')
                </div>
                <br>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td width="3%" align="center">รหัสห้อง</td>
                            <td width="8%" align="center">ชื่อห้อง</td>
                            <td width="8%" align="center">ประเภทห้อง</td>
                            <td width="8%" align="center">ความจุห้อง</td>
                            <td width="8%" align="center">รูป</td>
                            <td width="8%" align="center">คำอธิบาย</td>
                            <td width="8%" align="center">สถานะ</td>
                            <td width="8%" align="center">อุปกรณ์ภายในห้อง</td>
                            <!-- <td width="8%" width="8%">สถานะ</td> -->
                            <td width="3%">Edit</td>
                            <td width="3%" align="center">DELETE</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td width="3%" align="center">{{ $room->room_id }}</td>
                                <td width="8%" align="center">{{ $room->room_name }}</td>
                                <td width="8%" align="center">{{ $room->roomtype->name }}</td>
                                <td width="8%" align="center">{{ $room->capacity }}</td>
                                <td width="8%" align="center">
                                    @if ($room->room_pic)
                                        @php
                                            $images = json_decode($room->room_pic, true);
                                        @endphp
                                        @if (is_array($images) && !empty($images))
                                            <img src="{{ asset('images/' . $images[0]) }}" alt="Room Image"
                                                style="width:150px;">
                                        @endif
                                    @endif
                                </td>
                                <td width="8%" align="center">{{ $room->description }}</td>
                                <td width="8%" align="center">
                                    @if ($room->status == 1)
                                        <span class="badge bg-danger">ไม่พร้อมใช้งาน</span>
                                    @else
                                        <span class="badge bg-success">พร้อมใช้งาน</span>
                                    @endif
                                </td>
                                <td width="8%" align="center">
                                    <a href="{{ route('room.roomasset', $room->room_id) }}" class="btn btn-info text-white">
                                        <i class="nav-icon fas fa-laptop"></i> ดูรายละเอียด</a>
                                </td>
                                <td width="3%">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editRoomModal{{ $room->room_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editRoomModal{{ $room->room_id }}" tabindex="-1"
                                        aria-labelledby="editRoomModalLabel{{ $room->room_id }}" aria-hidden="true">
                                        @include('room.edit', ['room' => $room])
                                    </div>
                                </td>
                                <td width="3%" align="center">
                                    <form id="delete-form-{{ $room->room_id }}"
                                        action="{{ route('roomsdestroy', $room->room_id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <form action="{{ route('roomsdestroy', $room->room_id) }}" method="POST"
                                        class="delete-form" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
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
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                Swal.fire({
                    title: 'คุณต้องการ "ลบประเภทอุปกรณ์" ใช่หรือไม่?',
                    // text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
