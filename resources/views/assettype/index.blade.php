@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" align="center">
                <h3>ประเภทอุปกรณ์</h3>
            </div>
            <div class="card-body" width="100%">
                <div class="text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#assetTypeModal">
                        <i class="fas fa-plus"></i> เพิ่มข้อมูล
                    </button>
                </div>
                <div class="modal fade" id="assetTypeModal" tabindex="-1" aria-labelledby="assetTypeModalLabel"
                    aria-hidden="true">
                    @include('assettype.create')
                </div>
                <br>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>ชื่อ</th>
                            <th>คำอธิบาย</th>
                            <th>สถานะ</th>
                            <th width="15%">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assetTypes as $assetType)
                            <tr>
                                <td>{{ $assetType->type_id }}</td>
                                <td>{{ $assetType->type_name }}</td>
                                <td>{{ $assetType->description }}</td>
                                <td>{!! $assetType->status
                                    ? '<span class="badge badge text-white bg-success">เปิดใช้งาน</span>'
                                    : '<span class="badge badge text-white bg-danger">ปิดใช้งาน</span>' !!}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editassetTypeModal{{ $assetType->type_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editassetTypeModal{{ $assetType->type_id }}" tabindex="-1"
                                        aria-labelledby="editassetTypeModalLabel{{ $assetType->type_id }}"
                                        aria-hidden="true">
                                        @include('assettype.edit', ['assetType' => $assetType])
                                    </div>
                                    <form action="{{ route('assettype.destroy', $assetType->type_id) }}" method="POST"
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
