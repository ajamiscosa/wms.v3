<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
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
    protected $table = 'stocktransfers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Number', 'Product',
        'Source', 'Destination', 'Remarks', 'Status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'Date'
    ];

    public function Product() {
        return $this->belongsTo('App\Product','Product','ID')->first();
    }

    public function TransferredBy() {
        return $this->belongsTo('App\User','created_by','ID')->first();
    }

    public function Source() {
        return $this->hasOne('App\Location','ID','Source')->first();
    }
    public function Destination() {
        return $this->hasOne('App\Location','ID','Destination')->first();
    }

    public function Status() {
        $status = trim($this->Status);

        switch($status) {
            case 'P': $status =  'Pending Approval'; break;
            case 'A': $status =  'Approved'; break;
            case 'V': $status =  'Voided'; break;
            default: $status = "Invalid"; break;
        }
        return $status;
    }
}