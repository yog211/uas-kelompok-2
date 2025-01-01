@extends('layouts.main')

@section('title', 'Dashboard')
@section('content')

<div class="container-fluid">
  <div class="row page-titles mx-0">
    <div class="col-sm-12 p-md-0">
      <div class="welcome-text">
        <h4>Hi, {{$user}}</h4>
        <p class="mb-0">
          Selamat Datang Di Dashboard
        </p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4 col-sm-4">
      <div class="card bg-{{$warna}}">
        <div class="card-body pb-0">
          <div class="row">
            <div class="col">
              <h5 class="text-{{$warnateks}}">Tanggal</h5>
              <span class="text-{{$warnateks}}">{{date('d-m-Y') }}</span>
            </div>
            <div class="col text-right">
              <h5 class="text-{{$warnateks}}"><i class="fa fa-caret-{{$io}}"></i>{{$tam}}</h5>
              <span class="text-{{$warnateks}}">{{$rata}}%</span>
            </div>
          </div>
        </div>
        <div class="stat-widget-two card-body">
          <div class="stat-content">
            <div class="stat-text text-{{$warnateks}}">
              Status Keuangan mu
            </div>
            <div class="stat-digit">
              <i class="fa fa-money text-{{$warnateks}}"></i> <span class="text-{{$warnateks}}">{{$statusmu}}</span>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-4 col-sm-4 ">
      <div class="card bg-info">
        <div class="stat-widget-two card-body">
          <div class="stat-content">
            <div class="stat-text text-dark">
              Total Uang Masuk
            </div>
            <div class="stat-digit">
              <i class="fa fa-money"></i> {{$uangmasukformat}}
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-4 col-sm-4">
      <div class="card">
        <div class="stat-widget-two card-body bg-danger">
          <div class="stat-content">
            <div class="stat-text text-white">
              Total Uang Keluar
            </div>
            <div class="stat-digit">
              <i class="fa fa-money text-white"></i> <span class="text-white">{{$uangkeluarformat}}</span>
            </div>
          </div>

          <!--untuk grafik-->
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 col-sm-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Grafik Uang Masuk Dan Keluar Perbulan</h4>
        </div>
        <div class="card-body">
          <div id="Grafik" class="ct-chart ct-golden-section"></div>
        </div>
      </div>
    </div>
    <!--untuk pie chart-->
    <div class="col-lg-6 col-sm-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Persentase Uang Masuk Dan Keluar</h4>
        </div>
        <div class="card-body">
          <canvas id="pie_chart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!--untuk tabel-->
  <div class="row">
    <div class="col-lg-12 ">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Transaksi Uang Masuk dan Keluar</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Sumber</th>
                  <th>Nominal</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $index => $uang)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $uang['sumber'] }}</td>
                  <td>{{ number_format($uang['nominal'], 0, ',', '.') }}</td>
                  <td>{{ $uang['tanggal'] }}</td>
                  <td>
                    <span class="badge badge-{{ $uang['status'] == 'Masuk' ? 'success' : 'danger' }}">
                      {{ $uang['status'] }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  @push('scripts')
  <script>
    const data = {
      labels: @json($labels),
      // Semua tanggal unik
      series: [
        @json($seriesMasuk),
        // Data Uang Masuk
        @json($seriesKeluar) // Data Uang Keluar
      ]
    };

    // Opsi untuk Line Chart
    const options = {
      lineSmooth: Chartist.Interpolation.cardinal({
        tension: 0.2
      }),
      axisY: {
        labelInterpolationFnc: function(value) {
          return '' + value.toLocaleString(); // Format angka jadi Rupiah
        },
        onlyInteger: true,
        low: 0
      },
      plugins: [
        Chartist.plugins.tooltip() // Tambahkan tooltip
      ]
    };

    // Inisialisasi Line Chart
    new Chartist.Line('#Grafik', data, options);

    //pie chart
    const pie_chart = document.getElementById("pie_chart").getContext('2d');

    // Data dari backend Laravel
    const totalMasuk = @json($totalUangMasuk);
    const totalKeluar = @json($totalUangKeluar);
    let total = totalMasuk + totalKeluar;

    // Hitung persentase
    let persenMasuk = (totalMasuk / total) * 100;
    let persenKeluar = (totalKeluar / total) * 100;
    // Inisialisasi Chart.js
    new Chart(pie_chart, {
      type: 'pie',
      data: {
        datasets: [{
          data: [persenMasuk, persenKeluar], // Persentase uang masuk dan keluar
          borderWidth: 0,
          backgroundColor: [
            "rgba(0, 123, 255, .9)", // Warna biru untuk Uang Masuk
            "rgba(255, 99, 132, .9)" // Warna merah untuk Uang Keluar
          ],
          hoverBackgroundColor: [
            "rgba(0, 123, 255, .1)", // Warna biru untuk Uang Masuk
            "rgba(255, 99, 132, .1)" // Warna merah untuk Uang Keluar
          ]
        }],
        labels: [
          "Uang Masuk", // Label untuk uang masuk
          "Uang Keluar" // Label untuk uang keluar
        ]
      },
      options: {
        responsive: true,
        legend: {
          display: true, // Tampilkan legenda
          position: 'bottom'
        },
        maintainAspectRatio: true,
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              // Ambil nilai data
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var value = dataset.data[tooltipItem.index];
              var label = data.labels[tooltipItem.index];

              // Tambahkan simbol % dan formatkan hasil
              return label + ': ' + value.toFixed(2) + '%';
            }
          }
        }
      }
    });
  </script>
  @endpush
  @endsection