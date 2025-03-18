<div>
    <h3>รายละเอียดการจอง</h3>

</div>
<table class="table table-bordered">
    <thead>
        <tr>
            {{-- <th>รหัสการจอง</th> --}}
            <th>ห้องที่จอง</th>
            <th>เวลาเริ่ม</th>
            <th>เวลาสิ้นสุด</th>
            {{-- <th>Status</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($schedules as $schedule)
            <tr>
                {{-- <td>{{ $schedule->schedule_id }}</td> --}}
                <td>{{ $schedule->room->room_name }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->dt_start)->format('H.i') }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->dt_end)->format('H.i') }}</td>
                {{-- <td>{{ $schedule->status == 1 ? 'Active' : 'Inactive' }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
