<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Name');
            $table->unsignedInteger('Manager')->default(0); // fk @ user
            $table->json('Approvers');
            $table->unsignedInteger('Parent')->nullable()->default(0); // fk @ self
            $table->unsignedInteger('GL')->nullable();
            $table->boolean('Legacy')->default(false);
            $table->boolean('Status')->default(true);
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
        Schema::dropIfExists('departments');
    }
}
