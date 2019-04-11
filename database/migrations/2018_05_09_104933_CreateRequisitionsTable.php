<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->increments('ID');
            $table->char('Type',2); // IR- Issuance | PR - Purchase
            $table->char('ChargeType',1); // S - Stock | D - Direct Charge
            $table->unsignedInteger('GLAccount'); // glid
            $table->string('OrderNumber');
            $table->dateTime('Date');
            $table->unsignedInteger('Requester'); // userid
            $table->unsignedInteger('Department'); // deptid
            $table->unsignedInteger('ChargeTo'); // deptid
            $table->unsignedInteger('Approver1')->nullable(); // to be selected sa pag create.
            $table->unsignedInteger('Approver2')->nullable(); // well, random to. kung sinong approver chargeToDept ang mag approve.
            $table->string('Purpose');
            $table->text('Remarks')->nullable();
            $table->string('Status')->default('P');
            /*
             * P = Pending 1st Approval
             * 1 = Pending Final Approval
             * A = Approved
             * V = Voided
             * C = Cancelled
             * X = Expired
             */
            $table->timestamps();

            $table->foreign('Requester')
                ->references('ID')->on('users');

            $table->foreign('Department')
                ->references('ID')->on('departments');

            $table->foreign('ChargeTo')
                ->references('ID')->on('departments');

            $table->foreign('Approver1')
                ->references('ID')->on('users');

            $table->foreign('Approver2')
                ->references('ID')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
}
