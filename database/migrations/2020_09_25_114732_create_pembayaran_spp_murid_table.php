<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranSppMuridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_spp_murid', function (Blueprint $table) {
            $table->string('id');
            $table->string('tagihan_spp_id');
            $table->bigInteger('siswa_id')->unsigned();
            $table->bigInteger('total_tagihan_spp');
            $table->bigInteger('nis_siswa');
            $table->string('nama_siswa');
            $table->enum('jk_siswa', ['l', 'p']);
            $table->integer('kelas_siswa');
            $table->string('jurusan_siswa');
            $table->string('telepon_siswa');
            $table->text('alamat_siswa');
            $table->string('bukti_pembayaran');
            $table->string('status');
            $table->date('tgl_bayar');
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_spp_murid');
    }
}
