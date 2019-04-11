<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Code');
            $table->string('Name');
            $table->unsignedInteger('SupplierType');
            $table->unsignedTinyInteger('Currency');
            $table->unsignedTinyInteger('DeliveryLeadTime');
            $table->unsignedInteger('Term');
            $table->unsignedInteger('DueDays');
            $table->string('Contact');
            $table->string('AddressLine1');
            $table->string('AddressLine2');
            $table->string('City');
            $table->string('State');
            $table->string('Zip');
            $table->string('Country');
            $table->string('Telephone1');
            $table->string('Telephone2');
            $table->string('FaxNumber');
            $table->string('Email');
            $table->string('Website');
            $table->boolean('Status');
            $table->char('Classification',1); // local or not
            $table->timestamps();

            $table->foreign('SupplierType')
                ->references('ID')->on('suppliertypes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Currency')
                ->references('ID')->on('currency')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Term')
                ->references('ID')->on('terms')
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
        Schema::dropIfExists('suppliers');
    }
}
