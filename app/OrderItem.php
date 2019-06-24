<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
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
    protected $table = 'orderitems';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PurchaseOrder', 'Requisition', 'LineItem', 'Quote'
    ];

    public function hasLineItem() { 
        try {
            $this->LineItem();
        }
        catch(\Exception $e){ 
            return false;
        }
        return true;
    }

    public function LineItem() {
        return $this->hasOne('App\LineItem','ID','LineItem')->firstOrFail();
    }

    public function SelectedQuote() {
        return $this->hasOne('App\Quote','ID','Quote')->firstOrFail();
    }

    public function Requisition() {
        return $this->hasOne('App\Requisition','ID','Requisition')->firstOrFail();
    }

    public function PurchaseOrder() {
        return $this->hasOne('App\PurchaseOrder','ID','PurchaseOrder')->first();
    }

    public function getReceivingReceipts() {
        return $this->hasMany('App\ReceiveOrder','OrderItem','ID')->get();
    }
}
