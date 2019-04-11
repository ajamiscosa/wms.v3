<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('LastName',30);
            $table->string('FirstName',30);
            $table->string('MiddleName',30)->nullable();
            $table->char('Gender',1);
            $table->date('Birthday');
            $table->string('Email');
            $table->string('ContactNumber');
            $table->string('Position')->nullable();
            $table->string('ImageFile');
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
        Schema::dropIfExists('people');
    }
}
