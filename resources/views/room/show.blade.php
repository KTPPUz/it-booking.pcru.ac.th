@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-center">
                <h3>ห้องปฏิบัติการ</h3>
            </div>
            <div class="card-body">
                <form id="searchForm" action="{{ route('rooms.search') }}" method="GET" class="mb-4">
                    <div class="row" style="margin-left:36%;">
                        <div class="col-md-5">
                            <select name="roomtype" class="form-control"
                                onchange="document.getElementById('searchForm').submit();">
                                <option value="">-- เลือกประเภทห้อง --</option>
                                @foreach ($roomtypes as $roomtype)
                                    <option value="{{ $roomtype->type_id }}"
                                        {{ request('roomtype') == $roomtype->room_type ? 'selected' : '' }}>
                                        {{ $roomtype->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <div class="container">
                    <div class="row">
                        @foreach ($rooms as $room)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    @php
                                        $images = json_decode($room->room_pic, true);
                                        $firstImage = is_array($images) && !empty($images) ? $images[0] : null;
                                    @endphp

                                    @if ($firstImage)
                                        <img src="{{ asset('images/' . $firstImage) }}" alt="Room Image"
                                            style="height: 200px; width: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ route('room.image', ['filename' => $room->room_pic]) }}"
                                            alt="Default Image" style="height: 200px; width: 100%; object-fit: cover;">
                                    @endif

                                    <div class="card-body">
                                        <h6 class="card-title">ห้อง : {{ $room->room_name }}</h6>
                                        <p class="card-text">
                                            ประเภท : {{ $room->roomtype->name ?? '' }} <br>
                                        </p>
                                        <p class="card-text" style="margin-top: -10px;">
                                            สถานะ :
                                            @if ($room->status == 0)
                                                <span class="badge bg-success">พร้อมใช้งาน</span>
                                            @else
                                                <span class="badge bg-danger">ไม่พร้อมใช้งาน</span>
                                            @endif
                                        </p>

                                        <a href="{{ route('rooms.detail', $room->room_id) }}"
                                            class="btn btn-warning">ดูรายละเอียด</a>
                                        {{-- 
                                        <a href="javascript:void(0);" class="btn btn-info btn-md px-4 text-white"
                                            onclick="showSweetAlert({{ $room->room_id }})" data-toggle="tooltip"
                                            title="สร้างการจองห้อง">
                                            จอง
                                        </a> --}}
                                        @if ($room->status == 0)
                                            <a href="{{ route('br.newbooking', ['room_id' => $room->room_id, 'id' => $booking->id ?? null]) }}"
                                                class="btn btn-info btn-md px-4 text-white">
                                                จอง
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.querySelector('select[name="roomtype"]').addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });


        function onRoomSelect(selectElement) {
            const roomId = selectElement.value;
            if (roomId) {
                showSweetAlert(roomId);
            }
        }

        function showSweetAlert(roomId) {
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
                    window.location.href = `/booking/newbooking`;
                }
            });
        }

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
                text: 'มีการจองห้องในช่วงเวลานี้แล้ว',
                confirmButtonText: 'ตกลง'
            });
        @endif
    </script>
@endpush
