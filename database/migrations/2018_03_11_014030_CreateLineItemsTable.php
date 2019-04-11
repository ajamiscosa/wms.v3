<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineitems', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('OrderNumber');
            $table->unsignedInteger('Product'); // fk
            $table->unsignedInteger('GLCode'); //fk
            $table->unsignedDecimal('Quantity',11,2);
            $table->boolean('Quoted')->default(false);
            $table->boolean('Ordered')->default(false);
            $table->boolean('Completed')->default(false);
            $table->timestamps();

            $table->foreign('Product')
                ->references('ID')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('GLCode')
                ->references('ID')->on('gl')
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
        Schema::dropIfExists('lineitems');
    }
}
