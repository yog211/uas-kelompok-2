<?php

namespace App\Http\Controllers;
use App\Models\UangMasuk;
use Illuminate\Http\Request;

class UangMasukController extends Controller
{

  public function index() {
    $uangmasuk = UangMasuk::latest()->get();
    return view('uang_masuk.index', [
      'uang_masuks' => $uangmasuk
    ]);
  }

  public function create() {
    return view('uang_masuk.create');
  }

  public function store(Request $request) {

    UangMasuk::create([
      'sumber_uang_masuk' => $request->sumber_uang_masuk,
      'nominal' => $request->nominal,
      'tgl_masuk' => $request->tgl_masuk,

    ]);

    // Berikan feedback sukses
    return redirect()->route('uang_masuk.index')->with('success', 'Data berhasil di tambahkan!');
  }

  public function edit($id) {
    $uangmasuk = UangMasuk::find($id);
    return view ('uang_masuk.edit', compact('uangmasuk'));
  }
  public function update(Request $request, $id) {

    $uangmasuk = UangMasuk::find($id);
    $uangmasuk->sumber_uang_masuk = $request->sumber_uang_masuk;
    $uangmasuk->nominal = $request->nominal;
    $uangmasuk->tgl_masuk = $request->tgl_masuk;


    // Simpan perubahan
    $uangmasuk->save();
    return redirect()->route('uang_masuk.index')->with('success', 'Data berhasil di tambahkan!');
  }


  public function destroy($id) {
    UangMasuk::find($id)->delete();
    return redirect()->back()->with('success', 'Data berhasil di hapus!');
  }

}