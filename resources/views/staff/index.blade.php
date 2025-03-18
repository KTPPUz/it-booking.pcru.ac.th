@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-center">
                <h3>ข้อมูลผู้ใช้งาน</h3>
            </div>
            <div class="card-body">
                <div class="text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staffCModal">
                        <i class="fas fa-plus"></i> เพิ่มผู้ใช้งาน
                    </button>
                </div><br>
                <div class="modal fade" id="staffCModal" tabindex="-1" aria-labelledby="staffCModalLabel"
                    aria-hidden="true">
                    @include('staff.create')
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ชื่อ</th>
                            <th>อีเมล</th>
                            <th>ประเภทเจ้าหน้าที่</th>
                            {{-- <th>แผนก</th> --}}
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffUsers as $user)
                            <tr>
                                <td>{{ $user->staff_id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->stafftype->name ?? '-' }}</td>
                                {{-- <td>{{ $user->department_id ?? 'N/A' }}</td> --}}
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editstaffModal{{ $user->staff_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editstaffModal{{ $user->staff_id }}" tabindex="-1"
                                        aria-labelledby="editstaffModalLabel{{ $user->staff_id }}" aria-hidden="true">
                                        @include('staff.edit', ['user' => $user])
                                    </div>
                                    <form action="{{ route('staff.destroy', $user->staff_id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('ยืนยันการลบ?')"><i
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
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    success ') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    error ') }}',
            });
        </script>
    @endif
@endsection
