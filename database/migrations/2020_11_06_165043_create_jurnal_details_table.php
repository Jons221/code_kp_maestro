<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akun_id');
            $table->unsignedBigInteger('jurnal_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->double('debit', 30, 2)->nullable();
            $table->double('credit', 30, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('akun_id')->references('id')->on('akuns');
            $table->foreign('jurnal_id')->references('id')->on('jurnals');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnal_lines');
    }
}
