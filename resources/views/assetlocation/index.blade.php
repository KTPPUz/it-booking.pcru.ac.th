@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" align="center">
                <h3>สถานที่อุปกรณ์</h3>
            </div>
            <div class="card-body" width="100%">
                <div class="text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#assetLocationCModal">
                        <i class="fas fa-plus"></i> เพิ่มข้อมูล
                    </button>
                </div>
                <div class="modal fade" id="assetLocationCModal" tabindex="-1" aria-labelledby="assetLocationCModalLabel"
                    aria-hidden="true">
                    @include('assetlocation.create')
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
                <br>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>รหัสอุปกรณ์วิชาการ</th>
                            <th>ห้อง</th>
                            <th>หน่วยงาน</th>
                            <th>หน่วยงานย่อย</th>
                            <th>ประเภทสถานที่</th>
                            <th>Is Current</th>
                            <th>วันเวลาที่ถูกย้าย</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assetLocations as $assetLocation)
                            <tr>
                                <td>{{ $assetLocation->location_id }}</td>
                                <td>{{ $assetLocation->asset->asset_ac_id }}</td>
                                <td>{{ $assetLocation->room->room_name }}</td>
                                <td>{{ $assetLocation->department->department_name }}</td>
                                <td>{{ $assetLocation->sect->sect_name }}</td>
                                <td>{{ $assetLocation->location_type }}</td>
                                <td>{{ $assetLocation->is_current ? 'Yes' : 'No' }}</td>
                                <td>{{ $assetLocation->moved_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editassetLocationModal{{ $assetLocation->location_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editassetLocationModal{{ $assetLocation->location_id }}"
                                        tabindex="-1"
                                        aria-labelledby="editassetLocationModalLabel{{ $assetLocation->location_id }}"
                                        aria-hidden="true">
                                        @include('assetlocation.edit', ['assetLocation' => $assetLocation])
                                    </div>

                                    <form action="{{ route('assetlocation.destroy', $assetLocation->location_id) }}"
                                        method="POST" class="delete-form" style="display:inline-block;">
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
                    title: 'คุณต้องการ "ลบกลุ่มอุปกรณ์" ใช่หรือไม่?',
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
