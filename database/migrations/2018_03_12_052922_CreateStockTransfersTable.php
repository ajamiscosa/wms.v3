<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocktransfers', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Number')->unique();
            $table->unsignedInteger('Product'); // fk
            $table->unsignedInteger('Source'); // fk
            $table->unsignedInteger('Destination'); // fk
            $table->string('Remarks')->nullable();
            $table->char('Status',1)->default('P');
            $table->timestamps();

            $table->foreign('Product')
                ->references('ID')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Source')
                ->references('ID')->on('locations');

            $table->foreign('Destination')
                ->references('ID')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocktransfers');
    }
}
