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
      onlyInteger: true
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
  const totalMasuk = @json($totalMasuk);
  const totalKeluar = @json($totalKeluar);

  // Inisialisasi Chart.js
  new Chart(pie_chart, {
    type: 'pie',
    data: {
      datasets: [{
        data: [totalMasuk, totalKeluar], // Data uang masuk dan keluar
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
      maintainAspectRatio: false
    }
  });
