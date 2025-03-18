<div class="sidebar" style="margin-top: -10px">
    <nav class="mt-2">

        @if (Auth::guard('web')->check())
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <p class="nav-link active bg-primary">Menu</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('bookings') }}">
                        <i class="nav-icon fas fa-calendar-alt"></i> จองห้อง
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('rooms.show') }}">
                        <i class="nav-icon fas fa-door-closed"></i> ห้องบริการ
                    </a>
                </li>
            </ul>
        @endif

        @if (Auth::guard('staff')->check() &&
                (Auth::guard('staff')->user()->type_id == 1 || Auth::guard('staff')->user()->type_id == 2))
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <!-- การจัดการตรวจสอบ -->
                <li class="nav-item">
                    <p class="nav-link active bg-warning text-center">จัดการตรวจสอบ</p>
                </li>
                <li class="nav-item">
                    <a href="{{ route('review.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-redo-alt"></i>
                        <p>รายการรออนุมัติ</p>
                        <span class="badge bg-warning ms-2 right">
                            {{ App\Models\Booking::where('doc_status', App\Models\Booking::STATUS_PENDING)->where('doc_state', App\Models\ModelConst::STATE_PROCESSING)->count() }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('review.indexsuccess') }}" class="nav-link">
                        <i class="nav-icon fas fa-check"></i>
                        <p>รายการอนุมัติแล้ว</p>
                        <span class="badge bg-success ms-2 right">
                            {{ App\Models\Booking::where('doc_status', App\Models\Booking::STATUS_APPROVED)->where('doc_state', App\Models\ModelConst::STATE_COMPLETED)->count() }}
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.bookingall') }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>รายการจองทั้งหมด</p>
                        <span class="badge bg-info ms-2 right">
                            {{ App\Models\Booking::count() }}
                        </span>
                    </a>
                </li>
            </ul>
        @endif
        @if (Auth::guard('staff')->check())
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <!-- จัดการข้อมูลอุปกรณ์ -->
                <li class="nav-item mt-2">
                    <p class="nav-link active bg-success text-center">จัดการข้อมูลอุปกรณ์</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rooms') }}">
                        <i class="nav-icon fas fa-door-closed"></i> ห้อง
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('assettype.index') }}">
                        <i class="nav-icon fas fa-list-alt"></i> ประเภทอุปกรณ์
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('assetgroup.index') }}">
                        <i class="nav-icon fas fa-layer-group"></i> กลุ่มอุปกรณ์
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('assets.index') }}">
                        <i class="nav-icon fas fa-laptop"></i> อุปกรณ์
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('assetlocation.index') }}">
                        <i class="nav-icon fas fa-search-location"></i> สถานที่อุปกรณ์
                    </a>
                </li>
            </ul>
        @endif
        @if (Auth::guard('staff')->check() && Auth::guard('staff')->user()->type_id == 1)
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <!-- การจัดการข้อมูล -->
                <li class="nav-item mt-2">
                    <p class="nav-link active bg-info text-center">จัดการข้อมูลผู้ใช้</p>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.index') }}">
                        <i class="nav-icon fas fa-user-shield"></i> เจ้าหน้าที่
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <!-- การจัดการข้อมูล -->
                <li class="nav-item mt-2">
                    <p class="nav-link active bg-danger text-center">ข้อมูลเชิงสถิติ</p>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.statistics') }}">
                        <i class="nav-icon fa-solid fa-chart-simple"></i> สถิติการจอง
                    </a>
                </li>
            </ul>
        @endif

        @guest
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">ปฏิทินการจอง</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rooms.show') }}">ห้องบริการ</a>
                </li>
            </ul>
        @endguest

    </nav>
</div>
