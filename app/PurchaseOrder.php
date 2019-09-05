<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class PurchaseOrder extends Model
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
    protected $table = 'purchaseorders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Code',
        'OrderNumber', 'Series',
        'Supplier',
        'ChargeNo', 'ChargeType',
        'OrderDate', 'DeliveryDate',
        'PaymentTerm',
        'Total', 'APAccount',
        'Remarks', 'Status', 'ProductLine',
        'PurchasingManager','OperationsManager','PlantManager','GeneralManager'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'OrderDate', 'DeliveryDate',
        'PurchasingManager','OperationsManager','PlantManager','GeneralManager'
    ];
	
    public function Requester() {
        return $this->belongsTo('App\User', 'created_by','ID')->first();
    }

    public function OrderItems() {
        return $this->hasMany('App\OrderItem', 'PurchaseOrder','ID')->get();
    }

    public function Supplier() {
        return $this->belongsTo('App\Supplier', 'Supplier', 'ID')->first();
    }

    public function ReceiveOrders() {
        return $this->hasMany('App\ReceiveOrder', 'PurchaseOrder', 'ID')->get();
    }

    public function PurchaseReturns() {
        return $this->hasMany('App\PurchaseReturn', 'PurchaseOrder', 'OrderNumber')->get();
    }

    public function Bills() {
        return $this->hasMany('App\Bill', 'PurchaseOrder', 'OrderNumber')->get();
    }

    public function ProductLine() {
        return $this->belongsTo('App\ProductLine','ProductLine','ID')->first();
    }

    public function PaymentTerm() {
        return $this->belongsTo('App\Term','PaymentTerm','ID')->first();
    }

    public function Logs() {
        return $this->hasMany('App\StatusLog','OrderNumber','OrderNumber')->get();
    }

    public function APAccount() {
        return $this->hasOne('App\GeneralLedger','ID','APAccount')->firstOrFail();
    }

    public function Requisition() {
        try{
            return $this->belongsTo('App\Requisition','ChargeNo','OrderNumber')->first();
        }catch(\ErrorException $exception) {
            dd($this->OrderNumber);
        }
    }

    public static function getNextInSeries() {

        $today = Carbon::today();

        $latestPO = new PurchaseOrder();
        $latestPO = $latestPO->latest()->first();

        $series = 1;
        if($latestPO) {
            if(strpos($latestPO->OrderNumber,$today->format('my'))!==false) {
                $series = $latestPO->Series + 1;
            }
        }

        return $series;
    }

    public function getRemainingDeliverableQuantity() {
        $total = 0;
        foreach($this->OrderItems() as $orderItem) {
            $lineItem = $orderItem->LineItem();

            $total += $lineItem->getRemainingDeliverableQuantity();
        }

        return $total;
    }


    public function getChargeType() {
        if($this->ChargeType=='S') {
            return "STOCKS";
        }
        else {
            return $this->ProductLine()->Identifier;
        }
    }

    public function getShipVia() {
        return sprintf("%s/%s", $this->ChargeNo, $this->getChargeType());
    }

    public static function findPObyOrderNumber($orderNumber) { 
        return PurchaseOrder::where('OrderNumber','=',$orderNumber)->first();
    }
}
