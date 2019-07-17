<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class InventoryLog extends Model
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
    protected $table = 'inventorylogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Inventory', 'Type', 'TransactionType',
        'Quantity', 'Initial', 'Final'
    ];

    public function getProduct() {
        return $this->belongsTo('App\Product','Product','ID')->first();
    }
}
