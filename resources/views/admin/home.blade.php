@php
  $active = 'index';
  $courseNames = $courses->pluck('name')->toArray();
  $courseStudents = $courses->pluck('students')->toArray();
@endphp
@extends('admin.master')
@section('title')
  <title>Starclasses</title>
@endsection
@section('content')
  <div class="search-result">
    <div class="container p-5">
      <div class=" row gx-5">
        <div class="col-3 text-white">
          <div class="d-flex align-items-center px-3 py-4 rounded" style="background-color:rgb(155 102 245)">
            <div class="col-3 fs-1"><i class="bi bi-eye"></i></div>
            <div class="col-9">
              <div>Visitors</div>
              <div class="fs-2">{{ $visitors }}</div>
            </div>
          </div>
        </div>
        <div class="col-3 text-white">
          <div class="d-flex align-items-center px-3 py-4 rounded" style="background-color:#00cf93">
            <div class="col-3 fs-1"><i class="bi bi-people"></i></div>
            <div class="col-9">
              <div>Users</div>
              <div class="fs-2">{{ count($users) }}</div>
            </div>
          </div>
        </div>
        <div class="col-3 text-white">
          <div class="d-flex align-items-center px-3 py-4 rounded" style="background-color:#ff5a83">
            <div class="col-3 fs-1"><i class="bi bi-currency-dollar"></i></div>
            <div class="col-9">
              <div>Sales</div>
              <div class="fs-2">{{ $totalSales }}</div>
            </div>
          </div>
        </div>
        <div class="col-3 text-white">
          <div class="d-flex align-items-center px-3 py-4 rounded" style="background-color:rgb(75, 161, 252)">
            <div class="col-3 fs-1"><i class="bi bi-cart"></i></div>
            <div class="col-9">
              <div>Orders</div>
              <div class="fs-2">{{ count($bills) }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container p-3">
      <div class="row">
        <div class="col-6"><canvas id="myChart4" style="width:100%;"></canvas></div>
        <div class="col-6"><canvas id="myChart" style="width:100%;max-width:600px"></canvas></div>
        <div class="col-6"><canvas id="myChart2" style="width:100%;max-width:600px"></canvas></div>
        <div class="col-6"><canvas id="myChart3" style="width:100%;max-width:600px"></canvas></div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    //Chart 1
    var xValues = ["Foreign Language", "Marketing", "Design", "Sales", "LifeStyle"];
    var yValues = [55, 49, 44, 24, 15];
    var barColors = [
      "#ad5df0",
      "rgb(236, 42, 237)",
      "#ff5a83",
      "#00cf93",
      "rgb(75, 161, 252)",
    ];

    new Chart("myChart", {
      type: "pie",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues,
        }, ],
      },
      options: {
        title: {
          display: true,
          text: "Percentage of faculties by student",
        },
      },
    });

    // Chart 2
    var xValues = {!! json_encode($courseNames) !!};
    var yValues = {!! json_encode($courseStudents) !!};
    var barColors = [
      "rgb(75, 161, 252)",
      "rgb(236, 42, 237)",
      "#ad5df0",
      "#ff5a83",
      "#00cf93",
    ];

    new Chart("myChart2", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues,
        }, ],
      },
      options: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Courses with the most students",
        },
      },
    });

    //Chart 3
    const xValues3 = [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150];
    const yValues3 = [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15];

    new Chart("myChart3", {
      type: "line",
      data: {
        labels: xValues3,
        datasets: [{
          fill: false,
          lineTension: 0,
          backgroundColor: "rgb(75, 161, 252)",
          borderColor: "rgba(75, 161, 252, 0.1)",
          data: yValues3,
        }, ],
      },
      options: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Statistics of the number of students by month",
        },
        scales: {
          yAxes: [{
            ticks: {
              min: 6,
              max: 16
            }
          }],
        },
      },
    });

    //Chart 4
    const xValues4 = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

    new Chart("myChart4", {
      type: "line",
      data: {
        labels: xValues4,
        datasets: [{
          data: [860, 1140, 1060, 1060, 1070, 1110, 1330, 2210, 7830, 2478],
          borderColor: "rgb(255, 90, 131)",
          fill: false
        }, {
          data: [1600, 1700, 1700, 1900, 2000, 2700, 4000, 5000, 6000, 7000],
          borderColor: "rgb(0, 207, 147)",
          fill: false
        }, {
          data: [300, 700, 2000, 5000, 6000, 4000, 2000, 1000, 200, 100],
          borderColor: "rgb(75, 161, 252)",
          fill: false
        }]
      },
      options: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Statistics of the number of students in the 3 hottest courses",
        },
      }
    });
  </script>
@endsection
