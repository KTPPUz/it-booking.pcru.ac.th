@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-center bg-orange">
                <h4>ตรวจสอบห้องว่าง</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('rooms.checkAvailable') }}" method="GET">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <label for="start_date"><i class="fa-solid fa-calendar-check"></i> วันที่เริ่ม</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}" min="{{ now()->toDateString() }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="end_date"><i class="fa-solid fa-calendar-check"></i> วันที่สิ้นสุด</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}" min="{{ request('start_date') ?? now()->toDateString() }}"
                                required>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            let startDateInput = document.getElementById("start_date");
                            let endDateInput = document.getElementById("end_date");

                            startDateInput.addEventListener("change", function() {
                                let startDate = startDateInput.value;
                                endDateInput.min = startDate; // Ensure end date cannot be before start date

                                // If the selected end date is before the start date, reset it
                                if (endDateInput.value < startDate) {
                                    endDateInput.value = startDate;
                                }
                            });
                        });
                    </script>

                    <div class="row mt-2 justify-content-center">
                        <div class="col-md-3">
                            <label for="room_id"><i class="fa-solid fa-person-booth"></i> ห้อง</label>
                            <select name="room_id" id="room_id" class="form-select">
                                <option value="">เลือกห้อง</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->room_id }}"
                                        {{ request('room_id') == $room->room_id ? 'selected' : '' }}>
                                        {{ $room->room_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-md-4" style="margin-left: 26%">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-rotate-right"></i> ตรวจสอบห้อง
                            </button>
                        </div>
                    </div>
                </form>

                @if (!empty($occupiedRooms) && count($occupiedRooms) > 0)
                    <div class="row mt-3 justify-content-center">
                        <div class="col-md-8">
                            <div class="alert alert-success">
                                <h4><i class="fa-solid fa-list"></i> ผลตรวจสอบห้อง</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ห้อง</th>
                                            <th>จองสำหรับ</th>
                                            <th>วันที่</th>
                                            <th>เวลาเริ่ม</th>
                                            <th>เวลาสิ้นสุด</th>
                                            <th>จำนวนคน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($occupiedRooms as $room)
                                            <tr>
                                                <td>{{ $room->room->room_name ?? '-' }}</td>
                                                <td>{{ $bookingDetails[$room->booking_id]['bookingtype_name'] ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($room->dt_start)->locale('th')->translatedFormat('d F Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($room->dt_start)->format('H:i') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($room->dt_end)->format('H:i') }}</td>
                                                <td>{{ $bookingDetails[$room->booking_id]['participant_count'] ?? '-' }}
                                                    {{-- {{ $room->participant_count }} --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row mt-3 justify-content-center">
                        <div class="col-md-8">
                            <div class="alert alert-danger">
                                <h4><i class="fa-solid fa-info-circle"></i> ไม่มีข้อมูลการจองในช่วงเวลาที่เลือก</h4>
                            </div>
                        </div>
                    </div>
                @endif
                <br>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
