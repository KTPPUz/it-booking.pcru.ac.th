@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-success">
            <h3 class="text-center text-white">เพิ่มข้อมูลการจองห้อง</h3>
        </div>
        <div class="card-body">
            <div class="text-end mb-3">
                <a href="{{ route('bookings') }}" class="btn btn-primary">
                    กลับ
                </a>
            </div>

            <form action="{{ route('bstore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3" style="margin-left:10px;">
                    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12">
                        <label class="form-label"><b>สำหรับการเรียนการสอน</b></label><br>
                        <input type="radio" name="is_classroom" value="1" required>
                    </div>
                    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12">
                        <label class="form-label"><b>สำหรับฝึกอบรม</b></label><br>
                        <input type="radio" name="is_ext" value="1" required>
                    </div>
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
                        <!-- เหตุผลการจอง (ถ้าจำเป็น สามารถนำกลับมาใช้ได้) -->
                        <!--
                        <div class="mb-3">
                            <label for="reason" class="form-label"><b>เหตุผลการจอง</b></label>
                            <input type="text" class="form-control" id="reason" name="reason" required>
                        </div>
                        -->
                    </div>
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12"></div>
                </div>

                <div class="row mb-3" style="margin-left:10px;">
                    <div class="col-lg-3">
                        <!-- ปุ่มเปิด Modal เพื่อเพิ่มข้อมูล -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createbookingroomModal">
                            <i class="fas fa-plus"></i> วันที่จองและห้อง
                        </button>
                        <div class="modal fade" id="createbookingroomModal" tabindex="-1"
                            aria-labelledby="createbookingroomModalLabel" aria-hidden="true">
                            @include('bookingroom.create')
                        </div>
                    </div>

                </div>



                <div class="footer text-end" style="margin-right:10px;">
                    <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection