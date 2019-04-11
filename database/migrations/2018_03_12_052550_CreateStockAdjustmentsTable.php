<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockadjustments', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Number')->unique();
            $table->unsignedInteger('Product');
            $table->integer('Initial');
            $table->integer('Final');
            $table->string('Reason');
            $table->string('Remarks')->nullable();
            $table->char('Status',1)->default('P'); // P-Pending | A-Approved | V-Voided
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
        Schema::dropIfExists('stockadjustments');
    }
}
