<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class Requisition extends Model
{
    use Signature;
    
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
    protected $table = 'requisitions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Type',
        'ChargeType',
        'GLAccount',
        'OrderNumber',
        'Date',
        'Requester',
        'Department',
        'ChargeTo',
        'Approver1',
        'Approver2',
//        'Approved1',
//        'Approved2',
        'Purpose',
        'Remarks',
        'Status'
    ];

    protected $dates = [
        'Date'
    ];

    public function User() {
        return User::where('ID','=',$this->Requester)->first();
    }

    public function Requester() {
        return User::where('ID','=',$this->Requester)->first()->Person();
    }

    public function Approver1() {
        return User::where('ID','=',$this->Approver1)->first()->Person();
    }

    public function Approver2() {
        return User::where('ID','=',$this->Approver2)->first()->Person();
    }

    public function Department() {
        return Department::where('ID','=',$this->Department)->first();
    }

    public function ChargedTo() {
        return Department::where('ID','=',$this->ChargeTo)->first();
    }

    public function LineItems() {
        return $this->hasMany('App\LineItem', 'OrderNumber','OrderNumber')->get();
    }

    public function OrderItems() {
        $data = array();
        foreach($this->LineItems() as $lineItem) {
            array_push($data, $lineItem->OrderItem());
        }
        return $data;
    }

    public function Logs() {
        return $this->hasMany('App\StatusLog','OrderNumber','OrderNumber')->get();
    }

    public function ApprovalLog() {
        return $this->Logs()->where('LogType','=','A')->first();
    }

    public function Status() {
        switch($this->Status) {
            case 'P': return "Pending Initial Approval";
            case '1': return $this->Type=='IR'?"Pending Final Approval":"Pending First Approval";
            case '2': return "Pending Final Approval";
            case 'A': return "Approved";
            case 'C': return "Completed";
            case 'V': return "Voided";
            case 'E': return "Expired";
            case 'X': return "Cancelled";
            case 'Q': return "Pending Quotation";
        }
    }

    public function isFullyQuoted() {
        foreach($this->LineItems() as $lineItem) {
            if(!$lineItem->Quoted) return 0;
        }
        return 1;
    }

    public static function IssuanceRequests() {
        $rs = new Requisition();
        $issuanceList = $rs->where('Type','=','IR')->get();
        return $issuanceList;
    }


    public function getRemainingIssuableQuantity() {
        $lineItems = $this->LineItems();
        $total = 0;
        foreach($lineItems as $lineItem){
            $total += $lineItem->getRemainingReceivableQuantity();
        }
        return $total;
    }
}
