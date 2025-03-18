@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <div class="card-header" align="center">
            <h3>ตะกร้าของท่าน <span class="badge rounded-pill text-bg-warning">
                    @php
                        $count = $cartItems->count();
                        echo $count;
                    @endphp รายการ
                </span> </h3>
        </div>

        <div class="container">
            @if ($cartItems->count() == 0)
                <div class="alert alert-warning text-center">
                    <br><br>
                    <div>
                        <i class="fa fa-shopping-cart fa-2x"></i>

                    </div><br><br>
                    <h4><i class="fa-solid fa-exclamation-circle"></i> ไม่มีรายการในตะกร้า</h4>
                    <h5>เลือกห้องเรียน ห้องอบรม ห้องประชุม เพื่อทำการจองต่อไปได้เลย</h5><br><br>
                </div>
            @endif

            @foreach ($cartItems as $cartItemss)
                <table class="table">
                    <tr>
                        <td width="8%" align="center">
                            @if ($cartItemss->room->room_pic)
                                @php
                                    $images = json_decode($cartItemss->room->room_pic, true);
                                @endphp
                                @if (is_array($images) && !empty($images))
                                    <img src="{{ asset('images/' . $images[0]) }}" alt="Room Image" class="uniform-image">
                                @endif
                            @endif
                        </td>
                        <td width="5%">ห้อง: {{ $cartItemss->room->room_name }} </td>
                        <td align="center" width="5%">
                            {{ \Carbon\Carbon::parse($cartItemss->ubooking_date)->format('d/m/Y') }}
                        </td>
                        <td align="center" width="5%">
                            {{ \Carbon\Carbon::parse($cartItemss->ubooking_timestart)->format('H:i') }}
                        </td>
                        <td align="center" width="5%">
                            {{ \Carbon\Carbon::parse($cartItemss->ubooking_timeend)->format('H:i') }}
                        </td>
                        <td width="5%">จำนวน: {{ $cartItemss->participant_count }} คน</td>
                        <td width="5%">
                            <form
                                action="{{ route('userbooking.removeFromBooking', ['roomId' => $cartItemss->room_id, 'no' => $cartItemss->no]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn bg-info">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                </table>
            @endforeach
        </div>
        @if ($cartItems->count() != 0)
            <div class="container text-center">

                {{-- <a href="{{ route('userbooking.confirm') }}" class="btn bg-gradient-primary text-white">ทำการจอง</a> --}}

                {{-- <form action="{{ route('userbooking.confirm') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn bg-gradient-primary text-white">ทำการจอง</button>
                </form> --}}
                <button type="button" class="btn bg-success text-white btn-md px-4 " data-bs-toggle="modal"
                    data-bs-target="#createconfirmbookingModal">
                    ทำการจอง
                </button>
            </div>
            <div class="container">
                <div class="modal fade" id="createconfirmbookingModal" tabindex="-1"
                    aria-labelledby="createconfirmbookingModalLabel" aria-hidden="true">
                    @include('userbooking.confirmbooking')
                </div>
            </div>
        @endif

    </div>
@endsection

<style>
    .uniform-image {
        width: 160px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        /* Optional for rounded corners */
    }
</style>
@push('scripts')
    <script>
        // function confirmDelete(roomId, no) {
        //     Swal.fire({
        //         title: 'คุณแน่ใจหรือไม่?',
        //         text: "คุณต้องการลบรายการนี้ออกจากตะกร้าหรือไม่?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'ใช่, ลบเลย!',
        //         cancelButtonText: 'ยกเลิก'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             // สร้างฟอร์มเพื่อส่งคำขอลบ
        //             let form = document.createElement('form');
        //             form.action = `/userbooking/${roomId}/remove?no=${no}`;
        //             form.method = 'POST';

        //             // ใส่ CSRF Token
        //             let csrfInput = document.createElement('input');
        //             csrfInput.type = 'hidden';
        //             csrfInput.name = '_token';
        //             csrfInput.value = '{{ csrf_token() }}';
        //             form.appendChild(csrfInput);

        //             // ใส่ Method DELETE
        //             let methodInput = document.createElement('input');
        //             methodInput.type = 'hidden';
        //             methodInput.name = '_method';
        //             methodInput.value = 'DELETE';
        //             form.appendChild(methodInput);

        //             // เพิ่มฟอร์มใน DOM แล้วส่ง
        //             document.body.appendChild(form);
        //             form.submit();
        //         }
        //     });
        // }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'ลบรายการ!',
                text: 'ลบรายการในตะกร้าสำเร็จ!',
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
