<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePRTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('OrderNumber')->unique();
            $table->string('PurchaseOrder'); // fk
            $table->date('Date');
            $table->char('Status',1); // Default:P=Planned | A=Approved | V=void
            $table->unsignedDecimal('Total',9,2);
            $table->string('Remarks')->nullable();
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
        Schema::dropIfExists('returns');
    }
}
