<?php

namespace App\Http\Controllers;
use App\Models\UangKeluar;
use Illuminate\Http\Request;

class UangKeluarController extends Controller
{

  public function index() {
    $uangkeluar = UangKeluar::latest()->get();
    return view('uang_keluar.index', [
      'uang_keluars' => $uangkeluar
    ]);
  }

  public function create() {
    return view('uang_keluar.create');
  }

  public function store(Request $request) {
    UangKeluar::create([
      'sumber_uang_keluar' => $request->sumber_uang_keluar,
      'nominal' => $request->nominal,
      'tgl_keluar' => $request->tgl_keluar,

    ]);

    // Berikan feedback sukses
    return redirect()->route('uang_keluar.index')->with('success', 'Data berhasil di tambahkan!');
  }

  public function edit($id) {
    $uangkeluar = UangKeluar::find($id);
    return view ('uang_keluar.edit', compact('uangkeluar'));
  }
  public function update(Request $request, $id) {

    $uangkeluar = UangKeluar::find($id);
    $uangkeluar->sumber_uang_keluar = $request->sumber_uang_keluar;
    $uangkeluar->nominal = $request->nominal;
    $uangkeluar->tgl_keluar = $request->tgl_keluar;


    // Simpan perubahan
    $uangkeluar->save();
    return redirect()->route('uang_keluar.index')->with('success', 'Data berhasil di tambahkan!');
  }

  public function destroy($id) {
    UangKeluar::find($id)->delete();
    return redirect()->back()->with('success', 'Data berhasil di hapus!');
  }

}