<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentitems', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('PaymentNumber'); // fk
            $table->char('ItemType'); // B-Bill | M-Memo | A-Adjustment
            $table->string('ReferenceNumber'); // Used by Description in Adjustment
            $table->unsignedDecimal('Amount',11,2);
            $table->timestamps();

            $table->foreign('PaymentNumber')
                ->references('OrderNumber')->on('payments')
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
        Schema::dropIfExists('paymentitems');
    }
}
