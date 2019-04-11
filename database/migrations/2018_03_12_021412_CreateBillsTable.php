<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('OrderNumber')->unique();
            $table->string('PurchaseOrder'); // fk
            $table->unsignedTinyInteger('PaymentTerm'); // in days
            $table->date('Date');
            $table->unsignedDecimal('Total', 11,2);
            $table->string('Remarks')->nullable();
            $table->char('Status',1); // A-Approved | P-Pending | C-Completed | V-Voided
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('PurchaseOrder')
                ->references('OrderNumber')->on('purchaseorders')
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
        Schema::dropIfExists('bills');
    }
}
