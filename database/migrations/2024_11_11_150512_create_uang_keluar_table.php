<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up() {
    Schema::create('uang_keluars', function (Blueprint $table) {
      $table->id();
      $table->string('sumber_uang_keluar');
      $table->string('nominal');
      $table->string('tgl_keluar');
      $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down() {
    Schema::dropIfExists('uang_keluars');
  }
};