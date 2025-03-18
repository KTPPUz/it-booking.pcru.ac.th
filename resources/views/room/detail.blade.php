@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg">
            <div class="card-header bg-warning text-white text-center">
                <h3>รายละเอียดห้อง: <strong>{{ $room->room_name }}</strong></h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div id="carousel-room-{{ $room->room_id }}" class="carousel slide">
                            <div class="carousel-indicators">
                                @if ($room->room_pic)
                                    @php
                                        $images = json_decode($room->room_pic, true);
                                    @endphp
                                    @if (is_array($images) && !empty($images))
                                        @foreach ($images as $index => $image)
                                            <button type="button" data-bs-target="#carousel-room-{{ $room->room_id }}"
                                                data-bs-slide-to="{{ $index }}"
                                                class="{{ $index == 0 ? 'active' : '' }}"
                                                aria-label="Slide {{ $index + 1 }}"></button>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                            <div class="carousel-inner">
                                @if ($room->room_pic)
                                    @php
                                        $images = json_decode($room->room_pic, true);
                                    @endphp
                                    @if (is_array($images) && !empty($images))
                                        @foreach ($images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('images/' . $image) }}" class="d-block w-100 rounded"
                                                    alt="Room Image">
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carousel-room-{{ $room->room_id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carousel-room-{{ $room->room_id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-1">
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>ประเภทห้อง:</th>
                                        <td>{{ $room->roomtype->name ?? 'ไม่ระบุ' }}</td>
                                    </tr>
                                    <tr>
                                        <th>ความจุ:</th>
                                        <td>{{ $room->capacity }} คน</td>
                                    </tr>
                                    <tr>
                                        <th>รายละเอียด:</th>
                                        <td>{{ $room->description }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @if ($room->roomtype->type_id != '1')
                            <div class="card shadow-sm border-1 mt-2">
                                <div class="card-body bg-">
                                    <b>บริการอื่นๆ</b><b style="color:red;">*</b> <br>
                                    กาแฟ , โอวัลติน, อาหารว่าง 25 บาท/มื้อ/คน , อาหารกลางวัน 50 บาท/คน
                                </div>
                            </div>
                        @endif
                        @if ($room->roomtype->type_id == '1')
                            <div class="card shadow-sm border-1 mt-2">
                                <div class="card-body bg-">
                                    <b>รายละเอียด</b><b style="color:red;">*</b> <br>
                                    1) เครื่องคอมพิวเตอร์ สำหรับการสอน จำนวน 1 เครื่อง <br>
                                    2) เครื่องคอมพิวเตอร์ สำหรับบันทึกวีดีโอการสอน จำนวน 1 เครื่อง <br>
                                    3) โปรเจคเตอร์ จำนวน 1 เครื่อง <br>
                                    4) เครื่องปรับอากาศ <br>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            {{-- <form action="{{ route('userbooking.addToBooking', ['roomId' => $room->room_id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-lg px-4">ตะกร้า</button>

                                
                            </form> --}}
                            @if (Auth::check())
                                @if ($room->status == 0)
                                    <button type="button" class="btn btn-success btn-md px-4" data-bs-toggle="modal"
                                        data-bs-target="#createcartRoomModal">
                                        <i class="fa-solid fa-cart-shopping"></i> ตะกร้า
                                    </button>
                                    <div class="modal fade" id="createcartRoomModal" tabindex="-1"
                                        aria-labelledby="createcartRoomModalLabel" aria-hidden="true">
                                        @include('userbooking.cartmodal', ['room' => $room])
                                    </div>
                                @endif
                            @endif

                            {{-- <a href="javascript:void(0);" class="btn btn-info btn-md px-4 text-white"
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
            </div>
        </div>
    </div>

@endsection

<style>
    .carousel-item img {
        max-height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    th {
        text-align: left;
        width: 35%;
        color: #555;
    }

    td {
        color: #333;
    }

    .card {
        border-radius: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('alert'))
                Swal.fire({
                    icon: '{{ session('alert.type') }}', // success หรือ error
                    title: '{{ session('alert.type') === 'success' ? 'สำเร็จ!' : 'เกิดข้อผิดพลาด!' }}',
                    text: '{{ session('alert.message') }}',
                    confirmButtonText: 'ตกลง'
                });
            @endif
        });

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
    </script>
@endpush
