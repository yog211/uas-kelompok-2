<?php
namespace App\Http\Controllers;

use App\Models\UangMasuk;
use App\Models\UangKeluar;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{

  public function index() {
    // Ambil data Uang Masuk dan Uang Keluar
    // Ambil data dari database
    $uangMasuk = UangMasuk::select(DB::raw("DATE_FORMAT(tgl_masuk, '%Y-%m') as bulan"), DB::raw('SUM(nominal) as totalMasuk'))
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get();

    $uangKeluar = UangKeluar::select(DB::raw("DATE_FORMAT(tgl_keluar, '%Y-%m') as bulan"), DB::raw('SUM(nominal) as totalKeluar'))
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get();

    // Gabungkan bulan dari uang masuk dan keluar
    $allMonths = $uangMasuk->pluck('bulan')->merge($uangKeluar->pluck('bulan'))->unique()->sort();

    // Siapkan data nominal untuk masing-masing bulan
    $seriesMasuk = [];
    $seriesKeluar = [];
    $labels = [];

    foreach ($allMonths as $month) {
      // Konversi bulan ke format nama bulan
      $monthName = Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
      $labels[] = $monthName;

      // Cari total untuk bulan tertentu, jika tidak ada, default ke 0
      $totalMasuk = $uangMasuk->firstWhere('bulan', $month)->totalMasuk ?? 0;
      $totalKeluar = $uangKeluar->firstWhere('bulan', $month)->totalKeluar ?? 0;

      $seriesMasuk[] = $totalMasuk;
      $seriesKeluar[] = $totalKeluar;
    }


    //dashborad untuk username
    $user = User::pluck('username')->first();

    //pie chart
    $totalUangMasuk = UangMasuk::sum('nominal');
    $totalUangKeluar = UangKeluar::sum('nominal');
    //end

    //table
    $uangMasuks = UangMasuk::select('sumber_uang_masuk as sumber', 'nominal', 'tgl_masuk as tanggal', 'id')
    ->orderBy('id', 'desc') // Urutkan berdasarkan input terbaru
    ->get();

    // Ambil data Uang Keluar berdasarkan ID terbaru
    $uangKeluars = UangKeluar::select('sumber_uang_keluar as sumber', 'nominal', 'tgl_keluar as tanggal', 'id')
    ->orderBy('id', 'desc') // Urutkan berdasarkan input terbaru
    ->get();

    // Gabungkan data secara manual
    $data = [];

    // Tambahkan data Uang Masuk
    foreach ($uangMasuks as $uangMasuk) {
      $data[] = [
        'sumber' => $uangMasuk->sumber,
        'nominal' => $uangMasuk->nominal,
        'tanggal' => date('Y-m-d', strtotime($uangMasuk->tanggal)),
        // Format tanggal ke Y-m-d
        'status' => 'Masuk',
        'id' => $uangMasuk->id,
        // Tambahkan ID untuk urutan
      ];
    }

    // Tambahkan data Uang Keluar
    foreach ($uangKeluars as $uangKeluar) {
      $data[] = [
        'sumber' => $uangKeluar->sumber,
        'nominal' => $uangKeluar->nominal,
        'tanggal' => date('Y-m-d', strtotime($uangKeluar->tanggal)),
        // Format tanggal ke Y-m-d
        'status' => 'Keluar',
        'id' => $uangKeluar->id,
        // Tambahkan ID untuk urutan
      ];
    }

    // Urutkan data berdasarkan ID terbaru (input terbaru)
    usort($data, function ($a, $b) {
      return $b['id'] <=> $a['id']; // Urutkan berdasarkan ID dari yang terbaru
    });

    // Format tanggal menjadi dd-mm-yy saat menampilkan
    foreach ($data as &$item) {
      $item['tanggal'] = date('d-m-Y', strtotime($item['tanggal'])); // Format tanggal ke dd-mm-yy
    }
    //end table
    //dd($data);


    $uangmasukformat = 'Rp.' . number_format($totalUangMasuk, 0, ',', '.');

    $uangkeluarformat = 'Rp.' . number_format($totalUangKeluar, 0, ',', '.');

    if ($totalUangKeluar > $totalUangMasuk) {
      $statusmu = "Menurun";
      $warna = "danger";
      $warnateks = "white";
      $io = "down";
      $tam = '-Rp.' . number_format($totalUangKeluar-$totalUangMasuk, 0, ',', '.');
      if ($totalUangKeluar != 0) {
        $rata = "-". round(($totalUangKeluar / $totalUangMasuk) * 100, 1);
        // Persentase uang keluar dibandingkan dengan uang masuk
      } else {
        $rata = "0";
      }
    } else {
      $statusmu = "Baik";
      $warna = "success";
      $io = "up";
      $warnateks = "dark";
      $tam = '+Rp.' . number_format($totalUangMasuk-$totalUangKeluar, 0, ',', '.');
      if ($totalUangMasuk != 0) {
        $rata = "+ ".round(($totalUangKeluar / $totalUangMasuk) * 100, 1);
        // Persentase uang keluar dibandingkan dengan uang masuk
      } else {
        $rata = "0";
      }
    };

    // Kirim data ke view
    return view('dashboard', compact(
      'labels',
      'seriesMasuk',
      'seriesKeluar',
      'user',
      'totalUangMasuk',
      'totalUangKeluar',
      'data',
      'statusmu',
      'warna',
      'io',
      'warnateks',
      'tam',
      'rata',
      'uangmasukformat',
      'uangkeluarformat',
    ));
  }
}