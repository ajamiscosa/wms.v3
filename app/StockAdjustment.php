<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as RecordSignature;

class StockAdjustment extends Model
{
    use RecordSignature;
    
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
    protected $table = 'stockadjustments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Number','Product', 'Initial', 'Final', 'Reason', 'Remarks', 'Status'
    ];

    public function Product() {
        return $this->belongsTo('App\Product','Product','ID')->first();
    }

    public function Adjuster() {
        return $this->belongsTo('App\User','created_by','ID')->first();
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
