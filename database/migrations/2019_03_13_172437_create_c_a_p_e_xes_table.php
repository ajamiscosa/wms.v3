<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCAPEXesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capex', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('JobID');
            $table->string('JobDescription');
            $table->string('UsePhases');
            $table->string('Inactive');
            $table->string('Supervisor');
            $table->string('CustomerID')->nullable();
            $table->string('AddressLine1')->nullable();
            $table->string('AddressLine2')->nullable();
            $table->string('City')->nullable();
            $table->string('State')->nullable();
            $table->string('Zip')->nullable();
            $table->string('Country')->nullable();
            $table->date('StartDate');
            $table->date('ProjectedEndDate')->nullable();
            $table->date('ActualEndDate')->nullable();
            $table->string('JobStatus');
            $table->string('JobType')->nullable();
            $table->string('PONumber')->nullable();
            $table->unsignedInteger('BillingMethod')->default(0);
            $table->double('PercentComplete')->default(0);
            $table->double('LaborBurdenPercent')->default(0);
            $table->double('RetainagePercent')->default(0);
            $table->string('SecondContact')->nullable();
            $table->string('SpecialInstruct')->nullable();
            $table->string('SitePhoneNo')->nullable();
            $table->date('ContractDate')->nullable();
            $table->string('WorkPhoneNo')->nullable();
            $table->string('JobNote')->nullable();
            $table->string('DistributionPhaseID')->nullable();
            $table->string('DistributionCostCodeID')->nullable();
            $table->double('NoOfUnits')->default(0);
            $table->unsignedDecimal('DistributionEstRevenues',8,2)->default(0);
            $table->unsignedDecimal('DistributionEstExpenses',8,2)->default(0);
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
        Schema::dropIfExists('capex');
    }
}
