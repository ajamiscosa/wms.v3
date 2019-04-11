<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventorylogs', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('Product'); // fk
            $table->char('Type',1); // I=IN | O=OUT | R=Rebalance? Basta yong internal.
            $table->char('TransactionType',2);
            $table->unsignedDecimal('Quantity',11,2);
            $table->unsignedDecimal('Initial', 11,2);
            $table->unsignedDecimal('Final', 11,2);
            $table->timestamps();

            $table->foreign('Product')
                ->references('ID')->on('products')
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
        Schema::dropIfExists('inventorylogs');
    }
}
