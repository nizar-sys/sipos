<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trx_code')->nullable();
            $table->foreign('trx_code')->references('detail_transaksi')->on('tb_transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('change_payment');
            $table->bigInteger('total_payment');
            $table->string('proof_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_payments');
    }
}
