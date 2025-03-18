@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-center">
                <h3>อุปกรณ์ที่อยู่ภายในห้อง {{ $rooms->room_name }}</h3> <!-- Use appropriate room field -->
            </div>
            <div class="card-body">
                <table class="table table-bordered">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assetlocations as $assetLocation)
                            <tr>
                                <td>{{ $assetLocation->location_id }}</td>
                                <td>{{ $assetLocation->asset->asset_ac_id }}</td>
                                <td>{{ $assetLocation->room->room_name }}</td>
                                <td>{{ $assetLocation->department->department_name }}</td>
                                <td>{{ $assetLocation->sect->sect_name }}</td>
                                <td>{{ $assetLocation->location_type }}</td>
                                <td>{{ $assetLocation->is_current ? 'Yes' : 'No' }}</td>
                                <td>{{ $assetLocation->moved_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
