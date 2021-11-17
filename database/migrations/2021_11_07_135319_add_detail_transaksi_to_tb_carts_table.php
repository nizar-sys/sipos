<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailTransaksiToTbCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_carts', function (Blueprint $table) {
            $table->unsignedBigInteger('code_transaksi')->nullable();
            $table->foreign('code_transaksi')->references('detail_transaksi')->on('tb_transactions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_carts', function (Blueprint $table) {
            //
        });
    }
}
