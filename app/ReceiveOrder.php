<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class ReceiveOrder extends Model
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
    protected $table = 'receiveorders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'OrderNumber', 'PurchaseOrder',
        'ReferenceNumber', 'OrderItem',
        'Received', 'Quantity', 'Remarks','Series'
    ];

	
    public function PurchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder', 'PurchaseOrder', 'ID')->first();
    }

    public function OrderItem()
    {
        return $this->belongsTo('App\OrderItem', 'OrderItem','ID')->firstOrFail();
    }

    public function getOrderItems()
    {
        $order = new ReceiveOrder();
        $orders = $order
            ->where('PurchaseOrder','=',$this->PurchaseOrder)
            ->where('OrderNumber','=',$this->OrderNumber)
            ->get();
        return $orders;
    }

    public function getTotalDistributions() {
        return $this->getOrderItems()->count();
    }
}
