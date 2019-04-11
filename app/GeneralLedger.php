<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralLedger extends Model
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
    protected $table = 'gl';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Code', 'Description', 'Type', 'Status'
    ];

    public function CostCenter() {
        $cc = explode('-',$this->Code);
        return CostCenter::where('Code','=',$cc[1])->first();
    }

    public function ProductLine() {
        $pl = explode('-',$this->Code);
        return CostCenter::where('Code','=',$pl[2])->first();
    }

    public static function getGeneralLedgerCodesFor($type) {
        $generalLedger = new GeneralLedger();
        $gl = $generalLedger
            ->where('Type','=',$type)->get();
        return $gl;
    }

    public static function FindIdByCode($code) {
            return GeneralLedger::FindByCode($code)->ID;
    }

    public static function FindByCode($code) {
        $generalLedger = new GeneralLedger();
        try {
            $gl = $generalLedger->where('Code','=',$code)->firstOrFail();
            return $gl;
        } catch(\Exception $exception) {

        }
        return null;
    }

    public static function getInventoryGeneralLedgerCodes() {
        $data = array();
        array_push($data, GeneralLedger::FindByCode('13500-00-09'));
        array_push($data, GeneralLedger::FindByCode('13610-00-09'));
        array_push($data, GeneralLedger::FindByCode('13620-00-09'));

        return $data;
    }
    public static function getCapexGeneralLedgerCodes() {
        $data = array();
        $gl = new GeneralLedger();
        foreach($gl->getGeneralLedgerCodesFor('C') as $entry){
            array_push($data, $entry);
        }
        return $data;
    }
}
