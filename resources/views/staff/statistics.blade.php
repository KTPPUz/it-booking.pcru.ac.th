@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="fw-bold">ข้อมูลสถิติ</h2>

        <div class="row">
            <div class="col-md-3">
                <div class="card p-3">
                    <h6>รายการจองวันนี้</h6>
                    <h3>@php
                        echo $bookingss;
                    @endphp</h3>
                    <small class="text-success">+55% than last week</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h6>รายการจองทั้งหมด</h6>
                    <h3>@php
                        echo $bookingsc;
                    @endphp</h3>
                    <small class="text-success">+3% than last month</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h6>จำนวนผู้เข้าใช้วันนี้</h6>
                    <h3>@php
                        echo $todayParticipant;
                    @endphp</h3>
                    <small class="text-danger">-2% than yesterday</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h6>จำนวนผู้เข้าใช้ทั้งหมด</h6>
                    <h3>@php
                        echo $totalParticipants;
                    @endphp</h3>
                    <small class="text-success">+5% than yesterday</small>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            {{-- <div class="col-md-4">
                <div class="card p-3">
                    <h6>Website Views</h6>
                    <canvas id="websiteViewsChart"></canvas>
                    <small>Campaign sent 2 days ago</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h6>Daily Sales (+15%)</h6>
                    <canvas id="dailySalesChart"></canvas>
                    <small>Updated 4 min ago</small>
                </div>
            </div> --}}
            <div class="col-md-4">
                <div class="card p-3">
                    <h6>สถิติการจองใช้ห้อง (ในแต่ละเดือน)</h6>
                    <canvas id="completedTasksChart"></canvas>
                    <small>Just updated @ @php
                        echo date('Y');
                    @endphp
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // new Chart(document.getElementById('websiteViewsChart'), {
        //     type: 'bar',
        //     data: {
        //         labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
        //         datasets: [{
        //             label: 'Views',
        //             data: [50, 45, 15, 20, 45, 55, 70],
        //             backgroundColor: 'green'
        //         }]
        //     }
        // });

        // new Chart(document.getElementById('dailySalesChart'), {
        //     type: 'line',
        //     data: {
        //         labels: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
        //         datasets: [{
        //             label: 'Sales',
        //             data: [200, 180, 250, 400, 350, 300, 320, 280, 310, 330, 340, 300],
        //             borderColor: 'green',
        //             fill: false
        //         }]
        //     }
        // });

        var ctx = document.getElementById('completedTasksChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels), // ส่ง labels จาก Controller (Jan - Dec)
                datasets: [{
                    label: 'จำนวนการจอง',
                    data: @json($data), // ส่ง data จาก Controller (รวมทุกเดือน)
                    borderColor: 'green',
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true, // เริ่มที่ 0
                        max: 40, // กำหนดค่ามากสุดของ Y-axis
                        ticks: {
                            stepSize: 5 // กำหนดช่วงระหว่างค่าบนแกน Y (0, 5, 10, 15, ... 40)
                        }
                    }
                }
            }
        });
    </script>
@endsection
