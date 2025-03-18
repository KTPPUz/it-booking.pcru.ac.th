@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" align="center">
                <h3>อุปกรณ์</h3>
            </div>
            <div class="card-body" width="100%">
                <div class="text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#assetCModal">
                        <i class="fas fa-plus"></i> เพิ่มข้อมูล
                    </button>
                </div>
                <div class="modal fade" id="assetCModal" tabindex="-1" aria-labelledby="assetCModalLabel"
                    aria-hidden="true">
                    @include('asset.create')
                </div>
                <br>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>รหัสอุปกรณ์วิชาการ</th>
                            <th>กลุ่มอุปกรณ์</th>
                            <th>สถานะ</th>
                            <th>ข้อความ</th>
                            <th width="15%">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets as $asset)
                            <tr>
                                <td>{{ $asset->asset_id }}</td>
                                <td>{{ $asset->asset_ac_id }}</td>
                                <td>{{ $asset->assetGroup->group_name }}</td>
                                <td>{!! $asset->asset_status
                                    ? '<span class="badge badge text-white bg-success">เปิดใช้งาน</span>'
                                    : '<span class="badge badge text-white bg-danger">ปิดใช้งาน</span>' !!}</td>
                                <td>{{ $asset->asset_note }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editassetGroupModal{{ $asset->asset_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editassetGroupModal{{ $asset->asset_id }}" tabindex="-1"
                                        aria-labelledby="editassetGroupModalLabel{{ $asset->asset_id }}" aria-hidden="true">
                                        @include('asset.edit', ['asset' => $asset])
                                    </div>
                                    <form action="{{ route('assets.destroy', $asset->asset_id) }}" method="POST"
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
