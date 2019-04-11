<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CAPEX extends Model
{
    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = "ID";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'capex';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'JobID',
        'JobDescription',
        'UsePhases',
        'Inactive',
        'Supervisor',
        'CustomerID',
        'AddressLine1',
        'AddressLine2',
        'City',
        'State',
        'Zip',
        'Country',
        'StartDate',
        'ProjectedEndDate',
        'ActualEndDate',
        'JobStatus',
        'JobType',
        'PONumber',
        'BillingMethod',
        'PercentComplete',
        'LaborBurdenPercent',
        'RetainagePercent',
        'SecondContact',
        'SpecialInstruct',
        'SitePhoneNo',
        'ContractDate',
        'WorkPhoneNo',
        'JobNote',
        'DistributionPhaseID',
        'DistributionCostCodeID',
        'NoOfUnits',
        'DistributionEstRevenues',
        'DistributionEstExpenses'

    ];


    public static function FindIdByInventoryLedgerCode($code) {
        $prefix = Str::substr($code,0,5);
        switch($prefix) {
            case "13610": return 2;
            case "13620": return 3;
            case "13500": return 4;
            case "13300": return 5;
            default: return 1;
        }
    }
}

