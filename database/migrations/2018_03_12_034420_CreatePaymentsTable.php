<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('OrderNumber')->unique();
            $table->string('Bill'); //fk
            $table->unsignedInteger('PaymentMode'); //fk
            $table->date('Date');
            $table->unsignedDecimal('Subtotal', 11,2);
            $table->unsignedDecimal('LessFromMemos',11,2);
            $table->unsignedDecimal('Adjustments',11,2);
            $table->unsignedDecimal('Total',11,2);
            $table->string('Remarks')->nullable();
            $table->timestamps();

            $table->foreign('PaymentMode')
                ->references('ID')->on('paymentmodes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Bill')
                ->references('OrderNumber')->on('bills')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
