<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('UniqueID');
            $table->string('Name');
            $table->string('Description');
            $table->unsignedInteger('UOM');
            $table->unsignedInteger('Category');
            $table->unsignedInteger('ProductLine');
            $table->unsignedInteger('Series');
            $table->unsignedInteger('Location');
            $table->unsignedDecimal('Quantity',11,2);
            $table->unsignedDecimal('MinimumQuantity',11,2); //Reorder Point.
            $table->unsignedDecimal('MaximumQuantity',11,2);
            $table->unsignedDecimal('SafetyStockQuantity',11,2);
            $table->unsignedDecimal('ReOrderPoint',11,2);
            $table->boolean('Status')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('UOM')
                ->references('ID')->on('uom')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Location')
                ->references('ID')->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('ProductLine')
                ->references('ID')->on('productlines')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('ItemType')
                ->references('ID')->on('itemtypes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Category')
                ->references('ID')->on('categories')
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
        Schema::dropIfExists('products');
    }
}
