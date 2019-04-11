<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Username')->unique();
            $table->string('Password');
            $table->unsignedInteger('Person')->nullable();
            $table->unsignedInteger('Department')->nullable();
            $table->string('Roles')->nullable();
            $table->boolean('Status')->default(true);
            $table->timestamps();
            $table->rememberToken();
            $table->softDeletes();


            $table->foreign('Person')
                ->references('ID')->on('people')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('Department')
                ->references('ID')->on('departments')
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
        Schema::dropIfExists('users');
    }
}
