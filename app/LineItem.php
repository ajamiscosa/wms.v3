<?php

namespace App;

use Dompdf\Exception;
use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
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
    protected $table = 'lineitems';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'Type',
        'OrderNumber', 'GLCode', 'Product', 'Quantity',
        'Quoted','Ordered','Completed'

    ];

    // No need for a counterpart @ Variant Model
    public function Product()
    {
        return $this->belongsTo('App\Product', 'Product','ID')->first();
    }

    public function isRequisition() {
        return
            strncmp($this->OrderNumber, "IR", 2) === 0  // issuance request
            or
            strncmp($this->OrderNumber, "PR", 2) === 0; // purchase request

    }

    public function isOrderItem() {
        try {
            $orderItem = $this->hasOne('App\OrderItem','LineItem','ID')->first();
            if($orderItem!==null) {
                return true;
            }
        } catch(Exception $exception) {
            return false;
        }
        return false;
    }

    public function Requisition() {
        return Requisition::where('OrderNumber','=',$this->OrderNumber)->first();
    }

    public function GeneralLedger() {
        return $this->belongsTo('App\GeneralLedger', 'GLCode', 'ID')->first();
    }

    public function OrderItem() {
        return $this->hasOne('App\OrderItem','LineItem','ID')->first();
    }

    public function IssuanceReceipts() {
        return $this->hasMany('App\IssuanceReceipt','LineItem','ID')->get();
    }

    public static function findByID($id) {
        $lineItem = new LineItem();
        return $lineItem->where('ID','=',$id)->firstOrFail();
    }

    public function getIssuanceReceipts() {
        return $this->hasMany('App\IssuanceReceipt','LineItem','ID')->get();
    }

    public function getReceivingReceipts() {
        return $this->hasManyThrough('App\ReceiveOrder', 'App\OrderItem','ID','ID')->get();
    }

    public function getRemainingReceivableQuantity(){
        $receipts = $this->getIssuanceReceipts();
        
        $count = 0;
        foreach($receipts as $receipt) {
            $count += $receipt->Quantity;
        }

        return $this->Quantity - $count;
    }

    public function getRemainingDeliverableQuantity(){
        $orderItem = $this->OrderItem();
        $receipts = $orderItem->getReceivingReceipts();

        $count = 0;
        foreach($receipts as $receipt) {
            $count += $receipt->Quantity;
        }

        return $this->Quantity - $count;
    }
}
