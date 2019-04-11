<?php

namespace App;

use App\Classes\DTO\DTO;
use Illuminate\Database\Eloquent\Model;

class IssuanceReceipt extends Model
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
    protected $table = 'ir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'OrderNumber', 'Issuance', 'LineItem', 'Series', 'Received', 'Quantity', 'Remarks'
    ];

    public function getLineItem() {
        return $this->belongsTo('App\LineItem','LineItem','ID')->first();
    }

    public function getIssuance() {
        return $this->belongsTo('App\Requisition','Issuance','ID')->first();
    }

    public function getLineItems() {
        $data = array();
        $issuanceReceipt = new IssuanceReceipt();
        $issuanceReceipts = $issuanceReceipt->where('OrderNumber','=',$this->OrderNumber)->get();
        foreach($issuanceReceipts as $receipt) {
            $lineItem = $receipt->getLineItem();
            $product = $lineItem->Product();

            $dto = new DTO();
            $dto->UniqueID = $product->UniqueID;
            $dto->UOM = $product->UOM()->Abbreviation;
            $dto->Quantity = $receipt->Quantity;
            $dto->Description = $product->Description;

            array_push($data, $dto);
        }

        return $data;
    }
}
