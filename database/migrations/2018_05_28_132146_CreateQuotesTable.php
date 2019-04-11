<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('Product');
            $table->unsignedInteger('Supplier');
            $table->unsignedDecimal('Amount',8,2);
            $table->unsignedInteger('Currency');
            $table->date('ValidFrom');
            $table->unsignedInteger('Validity'); // in days.
            $table->boolean('Valid');
            $table->string('FileName'); // attached quotation pdf.
            $table->timestamps();

            $table->foreign('Product')
                ->references('ID')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Currency')
                ->references('ID')->on('currencies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Supplier')
                ->references('ID')->on('suppliers')
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
        Schema::dropIfExists('quotes');
    }
}
