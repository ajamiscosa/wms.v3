<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuslogs', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('OrderNumber');
            $table->char('TransactionType',2); // IR = Issuance Request | PR = Purchase Request | PO = Purchase Order
            $table->char('LogType',1); // N = New | A = Approve | V = Void | C = Complete
            $table->timestamps(); // created_at / created_by will be used to track the user.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuslogs');
    }
}
