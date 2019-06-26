<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePOTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorders', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('OrderNumber')->unique();
            $table->string('ChargeNo'); // RS Number
            $table->char('ChargeType')->default('S'); // S|Stock, D|Department
            $table->unsignedInteger('ProductLine'); // sequence number.
            $table->unsignedInteger('Series'); // sequence number.
            $table->unsignedInteger('Supplier');
            $table->date('OrderDate');
            $table->date('DeliveryDate');
            $table->unsignedTinyInteger('PaymentTerm'); // in days
            $table->unsignedDecimal('Total',9,2);
            $table->unsignedInteger('APAccount')->nullable();
            $table->string('Remarks')->nullable();
            $table->char('Priority')->default('N'); // N|Normal, U|Urgent
            $table->char('Status')->default('D');
            //D-Draft
            //P-Pending
            //1-Purchasing
            //2-Operations
            //3-Plant
            //A-Leadership
            //R-Partially Received
            //X-Rejected
            //Z-Completed
            $table->softDeletes();
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
        Schema::dropIfExists('purchaseorders');
    }
}
