<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
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
    protected $table = 'bills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'OrderNumber', 'PurchaseOrder', 'PaymentTerm', 'Date',
        'Total', 'Remarks', 'Status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'Date'
    ];
	
    public function Payments()
    {
        return $this->hasMany('App\Payment', 'Bill', 'OrderNumber')->get();
    }

    public function PurchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder', 'PurchaseOrder','OrderNumber')->first();
    }

    public function LineItems()
    {
        return $this->hasMany('App\LineItem','OrderNumber','OrderNumber')->get();
    }
}
