<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuanceReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ir', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('LineItem');
            $table->unsignedInteger('Series'); //
            $table->timestamp('Received');
            $table->unsignedDecimal('Quantity');
            $table->string('Remarks');
            $table->timestamps();

            $table->foreign('LineItem')
                ->references('ID')->on('lineitems')
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
        Schema::dropIfExists('ir');
    }
}
